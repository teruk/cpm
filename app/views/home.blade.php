@section('scripts')
    <link rel="stylesheet" type="text/css" href="{{ url('css/dataTables.bootstrap.css')}}">
    <script type="text/javascript" language="javascript" src="{{ url('js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" language="javascript" src="{{ url('js/dataTables.bootstrap.js')}}"></script>
	<script type="text/javascript" class="init">

        $(document).ready(function() {
            $('table.display').dataTable({
                "pagingType": "full",
                "paging":   false,
                "ordering": false,
                "displayLength": 50,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]]
            });
        } );

        $(document).ready(function() {
            $('#data_table').dataTable({
                "pagingType": "full",
                "displayLength": 50,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]]
            });
        } );

        $(document).ready(function() {
            $('#data2_table').dataTable({
                "order": [[ 0, 'desc' ]],
                "pagingType": "full",
                "displayLength": 50,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]]
            });
        } );

        $(document).ready(function() {
            var table = $('#example').DataTable({
                "pagingType": "full",
                "columnDefs": [
                    { "visible": false, "targets": 2 }
                ],
                "order": [[ 2, 'asc' ]],
                "displayLength": 50,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]],
                "drawCallback": function ( settings ) {
                    var api = this.api();
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;
         
                    api.column(2, {page:'current'} ).data().each( function ( group, i ) {
                        if ( last !== group ) {
                            $(rows).eq( i ).before(
                                '<tr class="info"><td colspan="5">'+group+'</td></tr>'
                            );
         
                            last = group;
                        }
                    } );
                }
            } );
 
    // Order by the grouping
    $('#example tbody').on( 'click', 'tr.info', function () {
        var currentOrder = table.order()[0];
        if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
            table.order( [ 2, 'desc' ] ).draw();
        }
        else {
            table.order( [ 2, 'asc' ] ).draw();
        }
    } );
} );
	</script>
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	    <li class="active">Startseite</li>
	</ol>
@stop

@section('main')
    <h4>Startseite</h4>
    <ul class="nav nav-tabs" style="margin-bottom: 15px;">
        <li class="active"><a href="#home" data-toggle="tab">Aktuelles</a></li>
        @if (Entrust::hasRole('Admin') || Entrust::can('view_planning') || sizeof(Entrust::user()->researchgroups) > 0)
            <li><a href="#courses" data-toggle="tab">Lehrveranstaltungen ({{ $turn->name }} {{ $turn->year }})</a></li>
            <li><a href="#employees" data-toggle="tab">Mitarbeiter</a></li>
            <li><a href="#mediumtermplannings" data-toggle="tab">Mittelfristige Lehrplanung</a></li>
        @endif
        <!-- <li><a href="#teachingassignments" data-toggle="tab">Lehraufträge</a></li> -->
        @if (Entrust::hasRole('Admin') || Entrust::can('view_planninglog'))
            <li><a href="#planninglog" data-toggle="tab">Änderungsprotokoll</a></li>
        @endif
    </ul>

    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="home">
            <div class="row">
                <div class="col-sm-8">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                          <h5>Ankündigungen</h5>
                          @foreach ($announcements as $announcement)
                          <table class="table table-striped table-condensed" cellspacing="0">
                            <thead>
                              <tr>
                                <th>{{ $announcement->subject }}</th>
                                <td align="right">erstellt am {{ date('d.m.Y - H:i', strtotime($announcement->created_at)) }} Uhr von {{ $announcement->user->name }}</td>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td colspan=2>{{ nl2br($announcement->content)}}</td>
                              </tr>
                              @if ($announcement->created_at != $announcement->updated_at)
                                <tr>
                                  <td colspan=2><i>Zuletzt bearbeitet am {{ date('d.m.Y - H:i', strtotime($announcement->updated_at)) }} Uhr</i></td>
                                </tr>
                              @endif
                            </tbody>
                          </table>
                          @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="panel panel-primary">
                      <div class="panel-body">
                        <h5>Anstehende Termine</h5>
                        @foreach ($appointeddays as $appointedday)
                            <table class="table table-striped table-condensed" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>{{ date("d.m.Y", strtotime($appointedday->date)) }}</th>
                                    </tr>    
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- <td><a href="{{ route('appointeddays.info', $appointedday->id) }}">{{ $appointedday->subject}}</a></td> -->
                                        <td>{{ $appointedday->subject}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endforeach
                      </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="courses">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-striped table-condensed" id="example" cellspacing="0">
                        <thead>
                            <tr>
                                <th>LV-Nummer</th>
                                <th>LV-Name</th>
                                <th>Modul</th>
                                <th>Lehrende</th>
                                <th>Raum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($planned_courses as $p)
                                <tr>
                                    <td>{{ $p->course_number }}</td>
                                    <td>{{ $p->course_title }}</td>
                                    <td>{{ $p->course->module->short }}</td>
                                    <td>
                                        @foreach($p->employees as $pe)
                                            {{ $pe->firstname}} {{ $pe->name }} ({{ $pe->pivot->semester_periods_per_week}} SWS)<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($p->rooms as $pr)
                                            {{ $pr->name }} ({{ Config::get('constants.weekdays_short')[$pr->pivot->weekday] }}, {{ substr($pr->pivot->start_time,0,5) }}-{{ substr($pr->pivot->end_time,0,5) }} Uhr)<br>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="employees">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-striped table-condensed" id="data_table" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Arbeitsbereich</th>
                                <th>Angestellt bis</th>
                                <th>nach am FB?</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $e)
                                @if ($e->inactive == 0)
                                    @if (date('d.m.Y', strtotime($e->employed_till)) < date('d.m.Y'))
                                        <tr class="warning">
                                    @else
                                        <tr class="success">
                                    @endif
                                @else
                                    <tr>
                                @endif
                                    <td>{{ $e->title }} {{ $e->firstname }} {{ $e->name}}</td>
                                    <td>{{ $e->researchgroup->name }} ({{ $e->researchgroup->short }})</td>
                                    <td>{{ date('d.m.Y', strtotime($e->employed_till)) }}</td>
                                    <td>
                                        @if ($e->inactive)
                                            nein
                                        @else
                                            ja
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="mediumtermplannings">
            <div class="row">
                <div class="col-sm-12">
                        <table class="table table-striped table-bordered table-condensed display" id="" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Modul</th>
                                         @foreach($turns as $t)
                                            <th>{{$t->name}} {{$t->year}}</th>
                                         @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $mtpgrid as $module )
                                    <tr>
                                        <td>
                                            {{ $module['short'] }}
                                        </td>
                                        @foreach( $module['turns'] as $turn )
                                            <td>
                                                @if (sizeof($turn))
                                                    @foreach( $turn as $employee)
                                                        @if (!$employee['annulled'])
                                                            <p>{{$employee['name']}} ({{$employee['semester_periods_per_week']}} SWS)</p>
                                                        @else
                                                            <p><s>{{$employee['name']}} ({{$employee['semester_periods_per_week']}} SWS)</s></p>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="teachingassignments">
            <div class="row">
                <div class="col-sm-12">
                    <h5>Lehraufträge:</h5>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="planninglog">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-striped table-condensed" id="data2_table">
                        <thead>
                            <tr>
                                <th>Datum</th>
                                <!-- <th>Kategorie</th> -->
                                <th>Benutzer</th>
                                <th>Änderung</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($planninglog as $pl)
                                @if ($pl->action_type == 0)
                                    <tr class='success'>
                                @endif
                                @if ($pl->action_type == 1)
                                    <tr class='info'>
                                @endif
                                @if ($pl->action_type == 2)
                                    <tr class='danger'>
                                @endif
                                    <td>{{ date('d.m.Y', strtotime($pl->created_at)) }}</td>
                                    <!-- <td>{{ Config::get('constants.planninglog_category')[$pl->category] }}</td> -->
                                    <td>{{ $pl->username }}</td>
                                    <td>
                                        @if (in_array($pl->planning_id, $deleted_planninglogs))
                                            {{ $pl->action }}
                                        @else
                                            <a href="{{ route('editPlanningInformation_path', array($pl->turn_id, $pl->planning_id)) }}">{{ $pl->action }}</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop