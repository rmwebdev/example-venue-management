@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.venue.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.venues.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.venue.fields.id') }}
                        </th>
                        <td>
                            {{ $venue->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.venue.fields.name') }}
                        </th>
                        <td>
                            {{ $venue->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.venue.fields.slug') }}
                        </th>
                        <td>
                            {{ $venue->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.venue.fields.location') }}
                        </th>
                        <td>
                            {{ $venue->location->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.venue.fields.event_types') }}
                        </th>
                        <td>
                            @foreach($venue->event_types as $key => $event_types)
                                <span class="label label-info">{{ $event_types->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.venue.fields.address') }}
                        </th>
                        <td>
                            {{ $venue->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.venue.fields.latitude') }}
                        </th>
                        <td>
                            {{ $venue->latitude }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.venue.fields.longitude') }}
                        </th>
                        <td>
                            {{ $venue->longitude }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.venue.fields.description') }}
                        </th>
                        <td>
                            {{ $venue->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.venue.fields.features') }}
                        </th>
                        <td>
                            {{ $venue->features }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.venue.fields.people_minimum') }}
                        </th>
                        <td>
                            {{ $venue->people_minimum }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.venue.fields.people_maximum') }}
                        </th>
                        <td>
                            {{ $venue->people_maximum }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.venue.fields.price_per_hour') }}
                        </th>
                        <td>
                            {{ $venue->price_per_hour }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.venue.fields.main_photo') }}
                        </th>
                        <td>
                            @if($venue->main_photo)
                                <a href="{{ $venue->main_photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $venue->main_photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.venue.fields.gallery') }}
                        </th>
                        <td>
                            @foreach($venue->gallery as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.venue.fields.is_featured') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $venue->is_featured ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.venues.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection