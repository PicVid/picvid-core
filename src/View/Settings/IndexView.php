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
                        <div class="card-body row">
                            <div class="col-6">
                                <h5><i class="fab fa-github" aria-hidden="true"></i>GitHub</h5>
                                <p>
                                    Der Quellcode steht auf <a href="https://github.com/PicVid" target="_blank">GitHub zur Verfügung</a>. Dort werden auch weitere Projekte und
                                    Informationen zu PicVid verwaltet. Auf GitHub gibt es außerdem eine Konfiguration
                                    für die <a href="https://github.com/PicVid/picvid-docker" target="_blank">Installation / Einrichtung in Docker</a>.
                                </p>
                                <h5><i class="fas fa-globe" aria-hidden="true"></i>Website</h5>
                                <p>
                                    Auf der <a href="https://picvid.de" target="_blank">Website</a> werden weitere Informationen und Resourcen zur Verfügung gestellt.
                                </p>
                            </div>
                            <div class="col-6">
                                <h5><i class="fas fa-wrench" aria-hidden="true"></i>Frameworks</h5>
                                <p>
                                    PicVid verwendet verschiedene Frameworks im Frontend-Bereich. Die folgenden
                                    Frameworks werden eingesetzt:
                                </p>
                                <p>
                                    <a href="https://daneden.github.io/animate.css/" target="_blank"><strong>Animate.css:</strong></a>
                                    Mit diesem CSS-Framework werden verschiedene Animationen realisiert.
                                </p>
                                <p>
                                    <a href="https://getbootstrap.com/" target="_blank"><strong>Bootstrap 4:</strong></a>
                                    Das grundlegende Design von PicVid wurde mit Bootstrap 4 realisiert. Durch eigene
                                    Anpassungen entsteht so ein individuelles aber sehr flexibles Design. Durch
                                    Bootstrap 4 wird so auch das responsive Design ermöglicht so dass PicVid auch auf
                                    den verschiedensten Endgeräten verwendet werden kann.
                                </p>
                                <p>
                                    <a href="http://www.dropzonejs.com/" target="_blank"><strong>Dropzone.js:</strong></a>
                                    Der Upload von Bildern wird im Frontend durch das Framework Dropzone.js unterstützt.
                                    Durch das Framework besteht auch die Möglichkeit mehrere Bilder hochzuladen und
                                    verschiedene Informationen darzustellen.
                                </p>
                                <p>
                                    <a href="https://fontawesome.com/" target="_blank"><strong>FontAwesome 5:</strong></a>
                                    FontAwesome ist eine Symbol-Schriftart. So können  verschiedene Icons über eine
                                    Schriftart verwendet werden.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>