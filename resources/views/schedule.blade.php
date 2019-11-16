@extends('layouts.app')

@section('title')
    Horario
@endsection

@section('content')
<div class="divTable unstyledTable">
<div class="divTableHeading">
<div class="divTableRow">
<div class="divTableHead">&nbsp;Hora</div>
<div class="divTableHead">&nbsp;Lunes</div>
<div class="divTableHead">Martes&nbsp;</div>
<div class="divTableHead">&nbsp;Mi&eacute;rcoles</div>
<div class="divTableHead">&nbsp;Jueves</div>
<div class="divTableHead">&nbsp;Viernes</div>
<div class="divTableHead">&nbsp;S&aacute;bado</div>
</div>
</div>
<div class="divTableBody">
<div class="divTableRow">
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
</div>
<div class="divTableRow">
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
</div>
<div class="divTableRow">
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
</div>
<div class="divTableRow">
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
</div>
<div class="divTableRow">
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
</div>
<div class="divTableRow">
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
</div>
</div>
</div>

<style>
div.unstyledTable {
  font-family: "Lucida Console", Monaco, monospace;
  border: 0px solid #000000;
  width: 70%;
  text-align: center;
  border-collapse: collapse;
  margin: auto;
  margin-top: 10vh;
  font-family: sans-serif;
}
.divTable.unstyledTable .divTableCell, .divTable.unstyledTable .divTableHead {
  border: 1px solid #DDDDDD;
  padding: 10px 5px;

}
.divTable.unstyledTable .divTableBody .divTableCell {
  font-size: 14px;
  background-color: white;
}
.divTable.unstyledTable .divTableHeading {
  background: #BC2424;
  border-bottom: 0px solid #FFFFFF;
}
.divTable.unstyledTable .divTableHeading .divTableHead {
  font-weight: normal;
  color: #FFFFFF;
  text-align: center;
  border-left: 0px solid #D0E4F5;
  border-color:  #9a0007;
 
}
.divTable.unstyledTable .divTableHeading .divTableHead:first-child {
  border-left: none;
}

/* DivTable.com */
.divTable{ display: table; }
.divTableRow { display: table-row; }
.divTableHeading { display: table-header-group;}
.divTableCell, .divTableHead { display: table-cell;}
.divTableHeading { display: table-header-group;}
.divTableFoot { display: table-footer-group;}
.divTableBody { display: table-row-group;}
</style>
@endsection