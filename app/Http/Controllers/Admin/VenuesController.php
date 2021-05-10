<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyVenueRequest;
use App\Http\Requests\StoreVenueRequest;
use App\Http\Requests\UpdateVenueRequest;
use App\Models\EventType;
use App\Models\Location;
use App\Models\Venue;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class VenuesController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('venue_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $venues = Venue::with(['location', 'event_types', 'media'])->get();

        return view('admin.venues.index', compact('venues'));
    }

    public function create()
    {
        abort_if(Gate::denies('venue_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $locations = Location::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $event_types = EventType::all()->pluck('name', 'id');

        return view('admin.venues.create', compact('locations', 'event_types'));
    }

    public function store(StoreVenueRequest $request)
    {
        $venue = Venue::create($request->all());
        $venue->event_types()->sync($request->input('event_types', []));
        if ($request->input('main_photo', false)) {
            $venue->addMedia(storage_path('tmp/uploads/' . basename($request->input('main_photo'))))->toMediaCollection('main_photo');
        }

        foreach ($request->input('gallery', []) as $file) {
            $venue->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('gallery');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $venue->id]);
        }

        return redirect()->route('admin.venues.index');
    }

    public function edit(Venue $venue)
    {
        abort_if(Gate::denies('venue_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $locations = Location::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $event_types = EventType::all()->pluck('name', 'id');

        $venue->load('location', 'event_types');

        return view('admin.venues.edit', compact('locations', 'event_types', 'venue'));
    }

    public function update(UpdateVenueRequest $request, Venue $venue)
    {
        $venue->update($request->all());
        $venue->event_types()->sync($request->input('event_types', []));
        if ($request->input('main_photo', false)) {
            if (!$venue->main_photo || $request->input('main_photo') !== $venue->main_photo->file_name) {
                if ($venue->main_photo) {
                    $venue->main_photo->delete();
                }
                $venue->addMedia(storage_path('tmp/uploads/' . basename($request->input('main_photo'))))->toMediaCollection('main_photo');
            }
        } elseif ($venue->main_photo) {
            $venue->main_photo->delete();
        }

        if (count($venue->gallery) > 0) {
            foreach ($venue->gallery as $media) {
                if (!in_array($media->file_name, $request->input('gallery', []))) {
                    $media->delete();
                }
            }
        }
        $media = $venue->gallery->pluck('file_name')->toArray();
        foreach ($request->input('gallery', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $venue->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('gallery');
            }
        }

        return redirect()->route('admin.venues.index');
    }

    public function show(Venue $venue)
    {
        abort_if(Gate::denies('venue_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $venue->load('location', 'event_types');

        return view('admin.venues.show', compact('venue'));
    }

    public function destroy(Venue $venue)
    {
        abort_if(Gate::denies('venue_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $venue->delete();

        return back();
    }

    public function massDestroy(MassDestroyVenueRequest $request)
    {
        Venue::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('venue_create') && Gate::denies('venue_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Venue();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}