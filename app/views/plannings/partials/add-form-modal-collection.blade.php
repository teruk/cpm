<!-- Vorlesung, Übungen, etc. erstellen -->
<div class="modal fade" id="planningBacModule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	@include('plannings.partials.courseM', array('select' => $lists['bachelor']))
</div>

<div class="modal fade" id="planningMaModule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	@include('plannings.partials.courseM', array('select' => $lists['master']))
</div>

<!-- Vorlesung, Übungen, etc. erstellen -->
<div class="modal fade" id="planningLecture" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	@include('plannings.partials.courseC', array('select' => $lists['lecture'], 'title' => 'Vorlesung'))
</div>

<div class="modal fade" id="planningExercise" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	@include('plannings.partials.courseC', array('select' => $lists['exercise'], 'title' => "Übung"))
</div>

<!-- Praktikum, Projekte etc. erstellen -->
<div class="modal fade" id="planningProseminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	@include('plannings.partials.courseI', array('select' => $lists['proseminar']))
</div>

<div class="modal fade" id="planningSeminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	@include('plannings.partials.courseI', array('select' => $lists['seminar']))
</div>

<div class="modal fade" id="planningProject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	@include('plannings.partials.courseP', array('select' => $lists['project']))
</div>

<div class="modal fade" id="planningIntegratedSeminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	@include('plannings.partials.courseI', array('select' => $lists['integrated_seminar']))
</div>

<div class="modal fade" id="planningPracticalCourse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	@include('plannings.partials.courseI', array('select' => $lists['practical_course']))
</div>

<div class="modal fade" id="planningOther" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	@include('plannings.partials.courseI', array('select' => $lists['other']))
</div>

<!-- modal dialog copy last turn -->
<div class="modal fade" id="copylastturn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	@include('plannings.partials.copylastturn')
</div>

<!-- modal dialog generate from mediumtermplanning -->
<div class="modal fade" id="mediumtermplanning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	@include('plannings.partials.mediumtermplanning')
</div>