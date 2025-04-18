<!-- Wikidata ID -->
<div class="form-group {{ $errors->has('wikidata') ? ' has-error' : '' }}">
    <label for="wikidata" class="col-md-3 control-label">Wikidata ID</label>
    <div class="col-sm-3">
        <input class="form-control" type="text" name="wikidata" aria-label="wikidata" id="wikidata" value="{{ old('wikidata', $item->wikidata) }}"{!!  (Helper::checkIfRequired($item, 'wikidata')) ? ' required' : '' !!} placeholder="Q31241" maxlength="30" pattern="Q[\d]+" />
        {!! $errors->first('name', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
