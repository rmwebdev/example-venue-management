@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.venue.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.venues.update", [$venue->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.venue.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $venue->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.venue.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="slug">{{ trans('cruds.venue.fields.slug') }}</label>
                <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', $venue->slug) }}" required>
                @if($errors->has('slug'))
                    <div class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.venue.fields.slug_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="location_id">{{ trans('cruds.venue.fields.location') }}</label>
                <select class="form-control select2 {{ $errors->has('location') ? 'is-invalid' : '' }}" name="location_id" id="location_id" required>
                    @foreach($locations as $id => $entry)
                        <option value="{{ $id }}" {{ (old('location_id') ? old('location_id') : $venue->location->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('location'))
                    <div class="invalid-feedback">
                        {{ $errors->first('location') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.venue.fields.location_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="event_types">{{ trans('cruds.venue.fields.event_types') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('event_types') ? 'is-invalid' : '' }}" name="event_types[]" id="event_types" multiple>
                    @foreach($event_types as $id => $event_types)
                        <option value="{{ $id }}" {{ (in_array($id, old('event_types', [])) || $venue->event_types->contains($id)) ? 'selected' : '' }}>{{ $event_types }}</option>
                    @endforeach
                </select>
                @if($errors->has('event_types'))
                    <div class="invalid-feedback">
                        {{ $errors->first('event_types') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.venue.fields.event_types_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="address">{{ trans('cruds.venue.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $venue->address) }}" required>
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.venue.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="latitude">{{ trans('cruds.venue.fields.latitude') }}</label>
                <input class="form-control {{ $errors->has('latitude') ? 'is-invalid' : '' }}" type="number" name="latitude" id="latitude" value="{{ old('latitude', $venue->latitude) }}" step="0.00000001">
                @if($errors->has('latitude'))
                    <div class="invalid-feedback">
                        {{ $errors->first('latitude') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.venue.fields.latitude_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="longitude">{{ trans('cruds.venue.fields.longitude') }}</label>
                <input class="form-control {{ $errors->has('longitude') ? 'is-invalid' : '' }}" type="number" name="longitude" id="longitude" value="{{ old('longitude', $venue->longitude) }}" step="0.00000001">
                @if($errors->has('longitude'))
                    <div class="invalid-feedback">
                        {{ $errors->first('longitude') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.venue.fields.longitude_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.venue.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $venue->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.venue.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="features">{{ trans('cruds.venue.fields.features') }}</label>
                <textarea class="form-control {{ $errors->has('features') ? 'is-invalid' : '' }}" name="features" id="features">{{ old('features', $venue->features) }}</textarea>
                @if($errors->has('features'))
                    <div class="invalid-feedback">
                        {{ $errors->first('features') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.venue.fields.features_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="people_minimum">{{ trans('cruds.venue.fields.people_minimum') }}</label>
                <input class="form-control {{ $errors->has('people_minimum') ? 'is-invalid' : '' }}" type="number" name="people_minimum" id="people_minimum" value="{{ old('people_minimum', $venue->people_minimum) }}" step="1">
                @if($errors->has('people_minimum'))
                    <div class="invalid-feedback">
                        {{ $errors->first('people_minimum') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.venue.fields.people_minimum_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="people_maximum">{{ trans('cruds.venue.fields.people_maximum') }}</label>
                <input class="form-control {{ $errors->has('people_maximum') ? 'is-invalid' : '' }}" type="number" name="people_maximum" id="people_maximum" value="{{ old('people_maximum', $venue->people_maximum) }}" step="1">
                @if($errors->has('people_maximum'))
                    <div class="invalid-feedback">
                        {{ $errors->first('people_maximum') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.venue.fields.people_maximum_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="price_per_hour">{{ trans('cruds.venue.fields.price_per_hour') }}</label>
                <input class="form-control {{ $errors->has('price_per_hour') ? 'is-invalid' : '' }}" type="number" name="price_per_hour" id="price_per_hour" value="{{ old('price_per_hour', $venue->price_per_hour) }}" step="0.01">
                @if($errors->has('price_per_hour'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price_per_hour') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.venue.fields.price_per_hour_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="main_photo">{{ trans('cruds.venue.fields.main_photo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('main_photo') ? 'is-invalid' : '' }}" id="main_photo-dropzone">
                </div>
                @if($errors->has('main_photo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('main_photo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.venue.fields.main_photo_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="gallery">{{ trans('cruds.venue.fields.gallery') }}</label>
                <div class="needsclick dropzone {{ $errors->has('gallery') ? 'is-invalid' : '' }}" id="gallery-dropzone">
                </div>
                @if($errors->has('gallery'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gallery') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.venue.fields.gallery_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_featured') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_featured" value="0">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ $venue->is_featured || old('is_featured', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">{{ trans('cruds.venue.fields.is_featured') }}</label>
                </div>
                @if($errors->has('is_featured'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_featured') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.venue.fields.is_featured_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    Dropzone.options.mainPhotoDropzone = {
    url: '{{ route('admin.venues.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="main_photo"]').remove()
      $('form').append('<input type="hidden" name="main_photo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="main_photo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($venue) && $venue->main_photo)
      var file = {!! json_encode($venue->main_photo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="main_photo" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}
</script>
<script>
    var uploadedGalleryMap = {}
Dropzone.options.galleryDropzone = {
    url: '{{ route('admin.venues.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="gallery[]" value="' + response.name + '">')
      uploadedGalleryMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedGalleryMap[file.name]
      }
      $('form').find('input[name="gallery[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($venue) && $venue->gallery)
      var files = {!! json_encode($venue->gallery) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="gallery[]" value="' + file.file_name + '">')
        }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection