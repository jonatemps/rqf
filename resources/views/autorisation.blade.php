<div class="m-4 mt-1">
    <div class="row">
        <div class="col-6 mt-4">
            <label class="mb-3" for=""><strong>Les autorisations de L'AB</strong></label> <br>
            {{-- <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" name="autorisationAb1" id="autorisationAb1" {{$demande->autorisationAb1 ? 'checked' : ''}} {{!Auth::user()->hasAccess('platform.autorisation.AB') ? 'disabled' : ''}}>
                <label class="form-check-label" for="autorisationAb1">
                    Cochez/Décochez
                </label>
            </div> --}}
            <div class="col-6">
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="autorisationAb1" id="btnradio1" autocomplete="off" value="Accorder" {{$demande->autorisationAb1 == "Accorder" ? 'checked' : ''}} {{!Auth::user()->hasAccess('platform.autorisation.AB') || $demande->autorisationRec ? 'disabled' : ''}}>
                <label class="btn btn-outline-secondary btn-sm" for="btnradio1">Accorder</label>

                <input type="radio" class="btn-check" name="autorisationAb1" id="btnradio2" autocomplete="off" value="En_attente" {{$demande->autorisationAb1 == "En_attente" ? 'checked' : ''}} {{!Auth::user()->hasAccess('platform.autorisation.AB') || $demande->autorisationRec ? 'disabled' : ''}}>
                <label class="btn btn-outline-secondary btn-sm" for="btnradio2">Mettre en attente</label>

                <input type="radio" class="btn-check" name="autorisationAb1" id="btnradio3" autocomplete="off" value="Rejeter" {{$demande->autorisationAb1 == "Rejeter" ? 'checked' : ''}} {{!Auth::user()->hasAccess('platform.autorisation.AB') || $demande->autorisationRec ? 'disabled' : ''}}>
                <label class="btn btn-outline-secondary btn-sm" for="btnradio3">Rejeter</label>
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="autorisationAb2" id="btnradio4" autocomplete="off" value="Accorder" {{$demande->autorisationAb2 == "Accorder" ? 'checked' : ''}} {{!Auth::user()->hasAccess('platform.autorisation.AB') || !$demande->autorisationRec || $demande->autorisationCaisse ? 'disabled' : ''}}>
                <label class="btn btn-outline-secondary btn-sm" for="btnradio4">Accorder</label>

                <input type="radio" class="btn-check" name="autorisationAb2" id="btnradio5" autocomplete="off" value="En_attente" {{$demande->autorisationAb2 == "En_attente" ? 'checked' : ''}} {{!Auth::user()->hasAccess('platform.autorisation.AB') || !$demande->autorisationRec || $demande->autorisationCaisse ? 'disabled' : ''}}>
                <label class="btn btn-outline-secondary btn-sm" for="btnradio5">Mettre en attente</label>

                <input type="radio" class="btn-check" name="autorisationAb2" id="btnradio6" autocomplete="off" value="Rejeter" {{$demande->autorisationAb2 == "Rejeter" ? 'checked' : ''}} {{!Auth::user()->hasAccess('platform.autorisation.AB') || !$demande->autorisationRec || $demande->autorisationCaisse ? 'disabled' : ''}}>
                <label class="btn btn-outline-secondary btn-sm" for="btnradio6">Rejeter</label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="m-4 mt-1">
    <div class="row">
        <div class="col-6">
            <label class="mb-3" for=""><strong>L'autorisation du recteur</strong></label> <br>
            {{-- <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" name="autorisationRec" id="autorisationRec" {{$demande->autorisationRec ? 'checked' : ''}} {{$demande->autorisationAb1 == false || !Auth::user()->hasAccess('platform.autorisation.Rec') ? 'disabled' : ''}}>
                <label class="form-check-label" for="autorisationRec">
                    Cochez/Décochez
                </label>
            </div> --}}
            <div class="col-6">
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="autorisationRec" id="btnradio7" autocomplete="off" value="Accorder" {{$demande->autorisationRec == "Accorder" ? 'checked' : ''}} {{$demande->autorisationAb1 != 'Accorder' || !Auth::user()->hasAccess('platform.autorisation.Rec') || $demande->autorisationCaisse ? 'disabled' : ''}}>
                <label class="btn btn-outline-secondary btn-sm" for="btnradio7">Accorder</label>

                <input type="radio" class="btn-check" name="autorisationRec" id="btnradio8" autocomplete="off" value="En_attente" {{$demande->autorisationRec == "En_attente" ? 'checked' : ''}} {{$demande->autorisationAb1 != 'Accorder' || !Auth::user()->hasAccess('platform.autorisation.Rec') || $demande->autorisationCaisse ? 'disabled' : ''}}>
                <label class="btn btn-outline-secondary btn-sm" for="btnradio8">Mettre en attente</label>

                <input type="radio" class="btn-check" name="autorisationRec" id="btnradio9" autocomplete="off" value="Rejeter" {{$demande->autorisationRec == "Rejeter" ? 'checked' : ''}} {{$demande->autorisationAb != 'Accorder' || !Auth::user()->hasAccess('platform.autorisation.Rec') || $demande->autorisationCaisse ? 'disabled' : ''}}>
                <label class="btn btn-outline-secondary btn-sm" for="btnradio9">Rejeter</label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="m-4 mt-1">
    <label class="mb-3" for=""><strong>Possibilités de trésorerie</strong></label> <br>
    {{-- <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" name="autorisationCaisse" id="autorisationCaisse" {{$demande->autorisationCaisse ? 'checked' : ''}} {{!Auth::user()->hasAccess('platform.autorisation.payer') ? 'disabled' : ''}}>
        <label class="form-check-label" for="autorisationCaisse">
            Cochez/Décochez
        </label>
    </div> --}}
    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
        <input type="radio" class="btn-check" name="autorisationCaisse" id="btnradio10" autocomplete="off" value="Suffisant" {{$demande->autorisationCaisse == "Suffisant" ? 'checked' : ''}} {{!Auth::user()->hasAccess('platform.autorisation.payer') || !$demande->autorisationAb2 ? 'disabled' : ''}}>
        <label class="btn btn-outline-secondary btn-sm" for="btnradio10">Suffisant</label>

        <input type="radio" class="btn-check" name="autorisationCaisse" id="btnradio11" autocomplete="off" value="Insuffisant" {{$demande->autorisationCaisse =="Insuffisant" ? 'checked' : ''}} {{!Auth::user()->hasAccess('platform.autorisation.payer') || !$demande->autorisationAb2 ? 'disabled' : ''}}>
        <label class="btn btn-outline-secondary btn-sm" for="btnradio11">Insuffisant</label>

        {{-- <input type="radio" class="btn-check" name="autorisationCaisse" id="btnradio12" autocomplete="off" value="Rejeter" {{$demande->autorisationCaisse =="Rejeter" ? 'checked' : ''}} {{!Auth::user()->hasAccess('platform.autorisation.payer') ? 'disabled' : ''}}>
        <label class="btn btn-outline-secondary btn-sm" for="btnradio12">Rejeter</label> --}}
    </div>
</div>
