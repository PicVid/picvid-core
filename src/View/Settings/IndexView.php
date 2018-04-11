<div class="container-fluid">
    <div class="row justify-content-center pt-3 pt-sm-5">
        <div class="col col-12 col-md-8 col-lg-6 col-xl-5">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="cleanup-tab" data-toggle="tab" href="#cleanup" role="tab" aria-controls="cleanup">Bereinigung</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info">Info</a>
                </li>
            </ul>
            <div class="tab-content" id="tab-cleanup">
                <div class="tab-pane fade show active" id="cleanup" role="tabpanel" aria-labelledby="cleanup-tab">
                    <div class="card">
                        <div class="card-body row">
                            <div class="col-6">
                                <h5><i class="fas fa-file"></i>Bereinigung des Dateisystems</h5>
                                <p>Es werden alle Bilder im Dateisystem gelöscht, welche nicht mehr in der Datenbank vorhanden sind.</p>
                                <a class="btn btn-sm btn-success" href="{{URL}}settings/cleanup-files">Dateien bereinigen</a>
                            </div>
                            <div class="col-6">
                                <h5><i class="fas fa-database"></i>Bereinigung der Datenbank</h5>
                                <p>Es werden Informationen zu Bildern in der Datenbank gelöscht, welche nicht mehr im Dateisystem vorhanden sind.</p>
                                <a class="btn btn-sm btn-success" href="{{URL}}settings/cleanup-database">Datenbank bereinigen</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="info" role="tabpanel" aria-labelledby="info-tab">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">GitHub</p>
                            <p class="card-text">Website</p>
                            <p class="card-text">Frameworks</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>