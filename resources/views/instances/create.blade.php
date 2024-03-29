@extends('layouts.app')

@section('title', __('Create Instances'))
@push('css')
    <style>
        .map-embed {
            width: 100%;
            height: 400px;
        }

        a.resultnya {
            color: #1e7ad3;
            text-decoration: none;
        }

        a.resultnya:hover {
            text-decoration: underline
        }

        .search-box {
            position: relative;
            margin: 0 auto;
            width: 300px;
        }

        .search-box input#search-loc {
            height: 26px;
            width: 100%;
            padding: 0 12px 0 25px;
            background: white url("https://cssdeck.com/uploads/media/items/5/5JuDgOa.png") 8px 6px no-repeat;
            border-width: 1px;
            border-style: solid;
            border-color: #a8acbc #babdcc #c0c3d2;
            border-radius: 13px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -ms-box-sizing: border-box;
            -o-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            -moz-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            -ms-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            -o-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
        }

        .search-box input#search-loc:focus {
            outline: none;
            border-color: #66b1ee;
            -webkit-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            -moz-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            -ms-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            -o-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
        }

        .search-box .results {
            display: none;
            position: absolute;
            top: 35px;
            left: 0;
            right: 0;
            z-index: 9999;
            padding: 0;
            margin: 0;
            border-width: 1px;
            border-style: solid;
            border-color: #cbcfe2 #c8cee7 #c4c7d7;
            border-radius: 3px;
            background-color: #fdfdfd;
            background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fdfdfd), color-stop(100%, #eceef4));
            background-image: -webkit-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: -moz-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: -ms-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: -o-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: linear-gradient(top, #fdfdfd, #eceef4);
            -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            -ms-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            -o-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            overflow: hidden auto;
            max-height: 34vh;
        }

        .search-box .results li {
            display: block
        }

        .search-box .results li:first-child {
            margin-top: -1px
        }

        .search-box .results li:first-child:before,
        .search-box .results li:first-child:after {
            display: block;
            content: '';
            width: 0;
            height: 0;
            position: absolute;
            left: 50%;
            margin-left: -5px;
            border: 5px outset transparent;
        }

        .search-box .results li:first-child:before {
            border-bottom: 5px solid #c4c7d7;
            top: -11px;
        }

        .search-box .results li:first-child:after {
            border-bottom: 5px solid #fdfdfd;
            top: -10px;
        }

        .search-box .results li:first-child:hover:before,
        .search-box .results li:first-child:hover:after {
            display: none
        }

        .search-box .results li:last-child {
            margin-bottom: -1px
        }

        .search-box .results a {
            display: block;
            position: relative;
            margin: 0 -1px;
            padding: 6px 40px 6px 10px;
            color: #808394;
            font-weight: 500;
            text-shadow: 0 1px #fff;
            border: 1px solid transparent;
            border-radius: 3px;
        }

        .search-box .results a span {
            font-weight: 200
        }

        .search-box .results a:before {
            content: '';
            width: 18px;
            height: 18px;
            position: absolute;
            top: 50%;
            right: 10px;
            margin-top: -9px;
            background: url("https://cssdeck.com/uploads/media/items/7/7BNkBjd.png") 0 0 no-repeat;
        }

        .search-box .results a:hover {
            text-decoration: none;
            color: #fff;
            text-shadow: 0 -1px rgba(0, 0, 0, 0.3);
            border-color: #2380dd #2179d5 #1a60aa;
            background-color: #338cdf;
            background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #59aaf4), color-stop(100%, #338cdf));
            background-image: -webkit-linear-gradient(top, #59aaf4, #338cdf);
            background-image: -moz-linear-gradient(top, #59aaf4, #338cdf);
            background-image: -ms-linear-gradient(top, #59aaf4, #338cdf);
            background-image: -o-linear-gradient(top, #59aaf4, #338cdf);
            background-image: linear-gradient(top, #59aaf4, #338cdf);
            -webkit-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
            -moz-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
            -ms-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
            -o-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
            box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
        }

        .lt-ie9 .search input#search-loc {
            line-height: 26px
        }
    </style>
@endpush


@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ __('Branches') }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/">{{ __('Dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('instances.index') }}">{{ __('Branches') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('Create') }}
                            </li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-dark" role="alert">
                                General Information
                            </div>

                            <form action="{{ route('instances.store') }}" method="POST">
                                @csrf
                                @method('POST')

                                @include('instances.include.form')

                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="alert alert-dark" role="alert">
                                        Data Operational time
                                    </div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Day</th>
                                                <th>Opening</th>
                                                <th>Closing</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($days as $i => $day)
                                                <tr>
                                                    <td><input type="text" style="width: 100%"
                                                            class="form-control @error('day.{{ $i }}') is-invalid @enderror"
                                                            name="day[]" value="{{ $day }}" placeholder=""
                                                            readonly autocomplete="off">
                                                        @error('day.{{ $i }}')
                                                            <span style="color: red;">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td><input type="time"
                                                            class="form-control @error('opening_hour.{{ $i }}') is-invalid @enderror"
                                                            name="opening_hour[]" placeholder=""
                                                            value="{{ old("opening_hour.{$i}") }}" autocomplete="off">
                                                        @error('opening_hour.{{ $i }}')
                                                            <span style="color: red;">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td><input type="time"
                                                            class="form-control @error('closing_hour{{ $i }}') is-invalid @enderror"
                                                            name="closing_hour[]" placeholder=""
                                                            value="{{ old("closing_hour.{$i}") }}" autocomplete="off">
                                                        @error('closing_hour{{ $i }}')
                                                            <span style="color: red;">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>


                                    <div class="form-group mt-3">
                                        <a href="{{ url()->previous() }}"
                                            class="btn btn-secondary">{{ __('Back') }}</a>

                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            var i = 1;

            function checkKosongLatLong() {
                if ($('#latitude').val() == '' || $('#longitude').val() == '') {
                    $('.alert-choose-loc').show();
                } else {
                    $('.alert-choose-loc').hide();
                }
            }

            var delay = (function() {
                var timer = 0;
                return function(callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })()


            // initialize map
            const getLocationMap = L.map('map');

            // initialize OSM
            const osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
            const osmAttrib = 'Leaflet © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
            const osm = new L.TileLayer(osmUrl, {
                minZoom: 8,
                maxZoom: 50,
                attribution: osmAttrib
            });
            // render map

            getLocationMap.scrollWheelZoom.disable()
            getLocationMap.setView(new L.LatLng('-6.8384545', '108.431134'), 14)
            getLocationMap.addLayer(osm)
            // initial hidden marker, and update on click
            const getLocationMapMarker = L.marker([0, 0]).addTo(getLocationMap);

            function getToLoc(lat, lng, displayname = null) {
                const zoom = 17;

                $.ajax({
                    url: `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`,
                    dataType: 'json',
                    success: function(data) {
                        $('#latitude').val(lat)
                        $('#longitude').val(lng)
                        if (displayname == null) {
                            $('#search_place').val(data.display_name)
                        } else {
                            $('#search_place').val(displayname)
                        }
                    }
                });
                getLocationMap.setView(new L.LatLng(lat, lng), zoom);
                getLocationMapMarker.setLatLng([lat, lng])
                $('.results').hide();
                checkKosongLatLong()

            }

            // listen click on map
            getLocationMap.on('click', function(e) {
                // set default lat and lng to 0,0
                const {
                    lat = 0, lng = 0
                } = e.latlng;
                // update text DOM

                $('#latitude').val(lat)
                $('#longitude').val(lng)
                // update marker position
                getToLoc(lat, lng)
                checkKosongLatLong()

            });



            $(document).on('click', '.resultnya', function() {

                const {
                    lat = 0, lng = 0, dispname = ''
                } = $(this).data();
                getToLoc(lat, lng, dispname)
            })

            function doSearching(elem) {
                $('.results').html(
                    '<li style="text-align: center;padding: 50% 0; max-height: 25hv;">Mengetik...</li>');
                const search = elem.val()
                delay(function() {
                    if (search.length >= 3) {
                        $('.results').html(
                            '<li style="text-align: center;padding: 50% 0; max-height: 25hv;"><i class="fa fa-refresh fa-spin"></i> Mencari...</li>'
                        );
                        const url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + search;
                        $.ajax({
                            url: url,
                            dataType: 'json',
                            success: function(data) {
                                $('.results').empty();
                                if (data.length > 0) {
                                    $.each(data, function(i, item) {
                                        $('.results').append(
                                            '<li><a class="resultnya" href="#" data-lat="' +
                                            item.lat + '" data-lng="' + item.lon +
                                            '" data-dispname="' + item
                                            .display_name + '">' + item
                                            .display_name +
                                            '<br/><i class="fa fa-map-marker"></i><span style="margin-left: 7px;">' +
                                            item.lat + ',' + item.lon +
                                            '</span></a></li>');
                                    })
                                } else {
                                    $('.results').html(
                                        '<li style="text-align: center;padding: 50% 0; max-height: 25hv;">Tidak ditemukan (Mungkin ada yang salah dengan ejaan, typo, atau kesalahan ketik)</li>'
                                    );
                                }
                            }
                        });
                    } else {
                        $('.results').html(
                            '<li style="text-align: center;padding: 50% 0; max-height: 25hv;">Masukan Pencarian (Min. 3 Karakter)</li>'
                        );
                    }
                }, 1000);
            }

            $('#search_place').focus(function() {
                $('.results').show();
            }).keyup(function() {
                doSearching($(this))
            }).blur(function() {
                setTimeout(function() {
                    $('.results').hide();
                }, 1000);
            })
            $('#search_place').on('paste', doSearching($(this)))
        });
    </script>

    <script>
        const options_temp = '<option value="" selected disabled>-- Select --</option>';

        $('#provinsi-id').change(function() {
            $('#kabkot-id, #kecamatan-id, #kelurahan-id').html(options_temp);
            if ($(this).val() != "") {
                getKabupatenKota($(this).val());
            }
            // onValidation('provinsi')
        })

        $('#kabkot-id').change(function() {
            $('#kecamatan-id, #kelurahan-id').html(options_temp);
            if ($(this).val() != "") {
                getKecamatan($(this).val());
            }
            // onValidation('kota')
        })

        $('#kecamatan-id').change(function() {
            $('#kelurahan-id').html(options_temp);
            if ($(this).val() != "") {
                getKelurahan($(this).val());
            }
            //onValidation('kecamatan')
        })

        $('#kelurahan-id').change(function() {
            if ($(this).val() != "") {
                $('#zip-kode').val($(this).find(':selected').data('pos'))
            } else {
                $('#zip-kode').val('')
            }
            //onValidation('kelurahan')
        });


        function getKabupatenKota(provinsiId) {
            let url = '{{ route('api.kota', ':id') }}';
            url = url.replace(':id', provinsiId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#kabkot-id').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.kabupaten_kota}</option>`
                    });
                    $('#kabkot-id').html(options_temp + options)
                    $('#kabkot-id').prop('disabled', false);
                },
                error: function(err) {
                    $('#kabkot-id').prop('disabled', false);
                    alert(JSON.stringify(err))
                }

            })
        }

        function getKecamatan(kotaId) {
            let url = '{{ route('api.kecamatan', ':id') }}';
            url = url.replace(':id', kotaId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#kecamatan-id').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.kecamatan}</option>`
                    });
                    $('#kecamatan-id').html(options_temp + options);
                    $('#kecamatan-id').prop('disabled', false);
                },
                error: function(err) {
                    alert(JSON.stringify(err))
                    $('#kecamatan-id').prop('disabled', false);
                }
            })
        }

        function getKelurahan(kotaId) {
            let url = '{{ route('api.kelurahan', ':id') }}';
            url = url.replace(':id', kotaId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#kelurahan-id').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}" data-pos="${value.kd_pos}">${value.kelurahan}</option>`
                    });
                    $('#kelurahan-id').html(options_temp + options);
                    $('#kelurahan-id').prop('disabled', false);
                },
                error: function(err) {
                    alert(JSON.stringify(err))
                    $('#kelurahan-id').prop('disabled', false);
                }
            })
        }
    </script>
@endpush
