@extends('layout.template')
@section('judul-halaman')
    <?php
    $user = Auth::user();

    $nama_depan = NULL;
    $nama_belakang = NULL;
    $username = NULL;
    $email = NULL;
    $nim = NULL;
    $universitas = NULL;
    $fakultas = NULL;
    $url_foto = NULL;

    foreach ($query_nama as $query_nama1) {
        $nama_depan = $query_nama1->nama_depan;
        $nama_belakang = $query_nama1->nama_belakang;
        $email = $query_nama1->email;
        $username = $query_nama1->username;
        $nim = $query_nama1->nim;
        //$universitas = $query_nama1->universitas;
        $fakultas = $query_nama1->fakultas;
        $url_foto = $query_nama1->url_foto;
    }
    ?>
    <title><?php echo $username;?> | PRD Online Course</title>

@endsection

@section('konten')
    <nav>
        <div class="nav-wrapper white">
            <a href="{{url('/')}}" class="navbar-brand blue-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
                        class="bold" style="font-size: 1.5em;">prd online course</span></a>
            <a href="#" data-activates="mobile-menu" class="button-collapse"><i
                        class="material-icons black-text">menu</i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="{{url('bimbingan')}}" class="blue-text thin">Bimbingan</a>
                </li>
                <?php
                if($user->peran == 2){
                ?>
                <li><a href="{{url('dosen/check_laporan')}}" class="blue-text thin">Laporan</a></li>
                <?php
                }
                ?>
                <li><a href="{{url('user')}}/<?php echo $user->username;?>/profil" class="blue-text thin">Profil</a>
                </li>
                <li>
                    <!-- Dropdown Trigger -->
                    <a class='dropdown-button blue-text thin' href='#' data-activates='dropdown1'>
                        <?php echo $user->username;?>
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                    <!-- Dropdown Structure -->
                    <ul id='dropdown1' class='dropdown-content'>
                        <li></li>
                        <li><a href="{{url('logout')}}">Keluar</a></li>
                    </ul>
                </li>
            </ul>
            <ul id="mobile-menu" class="side-nav">
                <li><a href="{{url('bimbingan')}}" class="blue-text thin">Bimbingan</a>
                <?php
                if($user->peran == 2){
                ?>
                <li><a href="{{url('dosen/check_laporan')}}" class="blue-text thin">Laporan</a></li>
                <?php
                }
                ?>
                <li><a href="{{url('user')}}/<?php echo $user->username;?>/profil" class="blue-text thin">Profil</a>
                </li>
                <li><a href="{{url('logout')}}" class="blue-text thin">Keluar</a></li>
            </ul>
        </div>
    </nav>
    <br/>
    <br/>
    <br/>
    <div class="section blue lighten-2">
        <div class="container row" style="padding: 2em 0 1em 0">
            <div class="row center-align">
                <div class="col s12 m12">
                    <div class="card-panel white">
                        <!-- Modal Ubah photo -->
                        <div id="modalUbah" class="modal">
                            <h5>Pilih Berkas</h5>
                            <p class="thin">Ukuran berkas file yang diizinkan adalah <span
                                        class="red-text">500 KB</span>.</p>
                            <form action="{{url('ubah_photo')}}" enctype="multipart/form-data" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                <div class="modal-content">

                                    <div class="file-field input-field">
                                        <div class="btn btn-sm">
                                            <span>File</span>
                                            <input type="file" name="photo">
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text">
                                        </div>
                                    </div>


                                </div>
                                <div class="modal-footer">
                                    {{--<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>--}}
                                    <button type="submit" class="btn waves-teal waves-effect">Kirim</button>
                                </div>
                            </form>
                        </div>

                        <a class="modal-trigger tooltipped" href="#modalUbah" data-position="top" data-delay="50" data-tooltip="Ubah photo">

                            <?php
                            if($url_foto == NULL){
                            ?>
                            <img class="circle responsive-img "
                                 src="{{url('/')}}/core/resources/assets/user_non_admin_assets/photos/default.jpg"
                                 style="height: 8em;width:8em;">

                            <?php
                            }else {
                            ?>
                            <img class="circle responsive-img "
                                 src="<?php echo $url_foto;?>"
                                 style="height: 8em;width:8em;">
                            <?php
                            }
                            ?>

                        </a>


                        <h5 class="blue-text">
                            <?php echo $nama_depan . " " . $nama_belakang . "<br/><h6 class='blue-text'>" . $email . "</h6>";?>
                        </h5>
                        <?php

                        //Menampilkan daftar topik yang sudah dikerjakan bila ada
                        $query_topik_sudah_dikerjakan = DB::table('mahasiswa_mengambil_topik')
                                ->select('nama_topik')
                                ->join('topik', 'topik.id', '=', 'mahasiswa_mengambil_topik.id_topik')
                                ->where('id_pengguna', '=', $user->id)
                                ->distinct()
                                ->get();
                        if(count($query_topik_sudah_dikerjakan != 0)){

                        ?>
                        <br/>
                        <span class="thin">
                        Telah mengerjakan topik
                        </span>
                        <hr/>
                        <div class="row col s2 m6 l12">

                            <?php
                            if(count($query_topik_sudah_dikerjakan) != 0){
                            foreach ($query_topik_sudah_dikerjakan as $query_topik_sudah_dikerjakan1) {
                            ?>
                            <div class="chip"><?php echo $query_topik_sudah_dikerjakan1->nama_topik;?></div>
                            <?php
                            }
                            }else {
                                echo "-";
                            }
                            ?>

                        </div>
                        <?php
                        }
                        ?>
                        <br/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <ul class="tabs">
                        <li class="tab col s3"><a href="{{url('user')}}/<?php echo $username;?>/profil" target="_self">Profil</a>
                        </li>
                        <li class="tab col s3"><a href="{{url('user')}}/<?php echo $username;?>/ubah_profil"
                                                  target="_self">Ubah</a></li>
                        <li class="tab col s3"><a class="active">Keamanan</a></li>
                    </ul>
                </div>
                <div id="test1" class="col s12 ">
                    <div class="row white" align="center" style="margin:0 0.1em 0 0.1em;">
                        <p style="padding:2em 2em 0em 2em;">
                            Silahkan isi form dibawah untuk melakukan ubah password akun mu.
                        </p>
                        @if (count($errors) > 0)
                            <div class="row">
                                <div class="card col m12 red white-text" style="margin:1em;">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            @if ( Session::has('berhasil') )
                                <div class="card col m12 red white-text" style="margin:1em;">
                                    {{Session::get('berhasil')}}
                                </div>
                            @elseif(Session::has('gagal'))
                                <div class="card col m12 red white-text" style="margin:1em;">
                                    {{Session::get('gagal')}}
                                </div>
                            @endif
                        </div>
                        <form class="col s12 m12 white" method="post" action="{{url('/keamanan')}}"
                              style="padding:4em;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                            <div class="row" align="left">
                                <div class="input-field col s12">
                                    <input value="" id="password_sekarang" type="password"
                                           class="validate" name="password_sekarang">
                                    <label for="password_sekarang">Tulis password sekarang</label>
                                </div>
                            </div>

                            <div class="row" align="left">
                                <div class="input-field col s12">
                                    <input value="" id="password_baru" type="password"
                                           class="validate" name="password">
                                    <label for="password_baru">Tulis password baru</label>
                                </div>
                            </div>

                            <div class="row" align="left">
                                <div class="input-field col s12">
                                    <input value="" id="password_baru_ulang" type="password"
                                           class="validate" name="password_confirmation">
                                    <label for="password_baru_ulang">Tulis ulang password baru</label>
                                </div>
                            </div>


                            <div class="row" align="left">
                                <div class="input-field col s12">
                                    <button class="btn waves-effect waves-light" type="submit" name="action">Submit</button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
                <div id="test2" class="col s12"></div>
                <div id="test3" class="col s12"></div>
            </div>

        </div>
    </div>
    <footer class="page-footer white">
        <div class="container">
            <div class="row">
                <div class="col s12 center-align">
                    <a href="http://localhost/prd/"><img
                                src="http://localhost/prd/core/resources/assets/images/logoShortcutIcon.png"/></a>
                    <p class="blue-text thin">© 2017 PPTIK Institut Teknologi Bandung</p>
                </div>
            </div>
        </div>
    </footer>


@endsection

@section('js')
    $(document).ready(function(){

    $('select').material_select();

    $('.modal-trigger').leanModal();

    $('a').smoothScroll({
    speed:1000
    });

    $('.tooltipped').tooltip({delay: 50});

    $(".button-collapse").sideNav({
    closeOnClick: true
    });

    $('ul.tabs a').on('click', function(e){
    if($(this).attr("target") ) {
    window.location = $(this).attr("href");
    }
    });

    $('.tooltipped').tooltip({delay: 50});

    });
@endsection
