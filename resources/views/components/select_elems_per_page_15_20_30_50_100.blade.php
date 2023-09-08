<label>{{__("Per page")}}</label>
<select id="elems_per_page" class="form-select form-select-sm">
	<option value="15" {{$currentPerPage == "15" ? "selected" : ""}}>15</option>
	<option value="20" {{$currentPerPage == "20" ? "selected" : ""}}>20</option>
	<option value="30" {{$currentPerPage == "30" ? "selected" : ""}}>30</option>
	<option value="50" {{$currentPerPage == "50" ? "selected" : ""}}>50</option>
	<option value="100" {{$currentPerPage == "100" ? "selected" : ""}}>100</option>
</select>