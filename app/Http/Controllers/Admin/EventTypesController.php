<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEventTypeRequest;
use App\Http\Requests\StoreEventTypeRequest;
use App\Http\Requests\UpdateEventTypeRequest;
use App\Models\EventType;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class EventTypesController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('event_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventTypes = EventType::with(['media'])->get();

        return view('admin.eventTypes.index', compact('eventTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('event_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.eventTypes.create');
    }

    public function store(StoreEventTypeRequest $request)
    {
        $eventType = EventType::create($request->all());

        foreach ($request->input('photo', []) as $file) {
            $eventType->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $eventType->id]);
        }

        return redirect()->route('admin.event-types.index');
    }

    public function edit(EventType $eventType)
    {
        abort_if(Gate::denies('event_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.eventTypes.edit', compact('eventType'));
    }

    public function update(UpdateEventTypeRequest $request, EventType $eventType)
    {
        $eventType->update($request->all());

        if (count($eventType->photo) > 0) {
            foreach ($eventType->photo as $media) {
                if (!in_array($media->file_name, $request->input('photo', []))) {
                    $media->delete();
                }
            }
        }
        $media = $eventType->photo->pluck('file_name')->toArray();
        foreach ($request->input('photo', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $eventType->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photo');
            }
        }

        return redirect()->route('admin.event-types.index');
    }

    public function show(EventType $eventType)
    {
        abort_if(Gate::denies('event_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.eventTypes.show', compact('eventType'));
    }

    public function destroy(EventType $eventType)
    {
        abort_if(Gate::denies('event_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventType->delete();

        return back();
    }

    public function massDestroy(MassDestroyEventTypeRequest $request)
    {
        EventType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('event_type_create') && Gate::denies('event_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new EventType();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}