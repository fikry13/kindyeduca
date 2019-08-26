@completeProfile
<div class="row">
    <div class="col-lg-4 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $sessions->where('status', 0)->count() }}</h3>

                <p>Permintaan Belum Di Respon</p>
            </div>
            <div class="icon">
                <i class="ion ion-archive"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-orange">
            <div class="inner">
                <h3>{{ $sessions->where('status', 3)->count() }}</h3>

                <p>Sesi Menunggu Persetujuan</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-checkmark-circle"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $sessions->where('status', 1)->count() }}</h3>

                <p>Sesi Berjalan</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-book"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
@endcompleteProfile