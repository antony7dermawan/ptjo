<div class="page-header card">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="icon feather icon-aperture bg-c-blue"> </i>
                <div class="d-inline">
                    <h5><?= $title ? $title : "Ini Title Content"; ?></h5>
                    <span><?= $description  ? $description : "Ini deskripsi content"; ?></span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class=" breadcrumb breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="/"><i class="feather icon-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#!"><?= $title ? $title : "Ini Title Content"; ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>