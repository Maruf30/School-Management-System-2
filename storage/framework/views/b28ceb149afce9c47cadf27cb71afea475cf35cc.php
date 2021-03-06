<?php /* G:\xampp730\htdocs\newxampp\Laravel\SMS17-05-2019\resources\views/admin/academic/student_attendance.blade.php */ ?>
<?php $__env->startSection('content'); ?>



<div class="card">
            <div class="card-body">

 <table class="table table-condensed table-hover table-responsive">
        <tr>



            <th>Student Name</th>
            <th>Roll Name</th>
            <th>Picture</th>
            <th>Present/Absent</th>


        </tr>
    
    

    <?php echo Form::open(array('route'=>'admin.daily_attendance.store',)); ?>

    
    <?php $__empty_1 = true; $__currentLoopData = $attendace; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $present): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

    <tr>
            
                    <input type="hidden" value="<?php echo date('Y-m-d'); ?>" name="date" id="date" title="Pick a date" />
               <td><?php echo e($present->first_name); ?></td>
               
               <td> <input type="hidden" name="roll[]" value="<?php echo $present->roll_no ?>"><?php echo e($present->roll_no); ?></td>
               <td>   <img class="portrait"  src="<?php echo e(asset('adminasset/images/teacherimages/'.$present->picture)); ?>"></td>
            

<td>
   
    <div class="pretty p-default p-curve p-toggle">
        <input type="hidden" name="status[]" value="0"><input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value">
        <div class="state p-success p-on">
            <label>Present</label>
        </div>
        <div class="state p-danger p-off">
            <label>Absent </label>
        </div>
    </div>

</td>
<td> <input type="hidden" name="class_id[]" value="<?php echo $present->class_id ?>" /></td>
                <td> <input type="hidden" name="student_id[]" value="<?php echo $present->student_id ?>" /></td>
                <td> <input type="hidden" name="session_id[]" value="<?php echo $present->session_id ?>" /></td>
                <td> <input type="hidden" name="section_id[]" value="<?php echo $present->section_id ?>" /></td>
                <td> <input type="hidden" name="shift_id[]" value="<?php echo $present->shift_id ?>" /></td>
                
                <td> <input type="hidden" name="id[]" value="<?php echo $present->id ?>" /></td>
                <!-- success -->
    


    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="5" class="bg-danger">No Student to Found</td></tr>
<?php endif; ?>
    </table>
    <input type="submit" id="" value="Submit" class="btn btn-primary">

    <?php echo Form::close(); ?>

</div>
</div>
</div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
   <script>
$(document).ready(function () {

 //header for csrf-token is must in laravel
 $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

  var url = "<?php echo e(URL::to('/')); ?>";
//Create Start shift

 clearform();

  $("#addBtn").click(function(){
    if($(this).val() == 'Save Exam'){
//         alert($("#shift_name").val());
// alert($("#session_id").val());
// alert($("#class_id").val());
// alert($("#active_id").val());

$.ajax({
                url:url+'/admin/shift',
                method: "POST",
                data:{
                  shift_name: $("#shift_name").val(),
                  session_id: $("#session_id").val(),
                  class_id: $("#class_id").val(),
                  active_id: $("#active_id").val()

                },
                success:function(d){
                  if(d.success){
                    alert(d.message);
                    //console.log(d);
                    location.reload();
                    clearform();

                  }
                },error:function(d){
                  console.log(d);
                }

            });
    }
  });
    //Create end shift

 //Update shift
 $("#exampleModal").on('click','#addBtn', function(){

    if($(this).val() == 'Update'){
 //alert($("#examid").val());
// alert($("#exam_start").val());
// alert($("#exam_end").val());
      // $url = url+'/admin/myexam/'+$("#examid").val();
      // console.log($url);
                $.ajax({
                 url:url+'/admin/shift/'+$("#examid").val(),
                method: "PUT",
                type: "PUT",
                data:{
                    shift_name: $("#shift_name").val(),
                    session_id: $("#session_id").val(),
                  class_id: $("#class_id").val(),
                  active_id: $("#active_id").val()

                },
                success: function(d){
                      if(d.success) {
                        alert(d.message);
                        location.reload();



                        }
                },
                error:function(d){
                    console.log(d);
                }
            });
            }
          });
             //Update shift end





  //Edit shift
  $(".card").on('click','#editBtn', function(){
            //alert()
            $examid = $(this).attr('rid');
            // console.log($examid);
            // return;
            $info_url = url + '/admin/shift/'+$examid+'/edit';
            // console.log($info_url);
            // return;
            $.get($info_url,{},function(d){
                //console.log(d);
                 populateForm(d);
                 location.hash = "ccccc";
                 $("#exampleModal").modal("toggle");
            });
        });
        //Edit shift end

        //Delete exam
        $(".card").on('click','#deleteBtn', function(){
            //alert()
            if(!confirm('Sure?')) return;
            $examid = $(this).attr('rid');
            //console.log($roomid);
            $info_url = url + '/admin/shift/'+$examid;
            $.ajax({
                url:$info_url,
                method: "DELETE",
                type: "DELETE",
                data:{
                },
                success: function(d){
                    if(d.success) {
                        //alert(d.message);
                        location.reload();
                        }
                },
                error:function(d){
                    console.log(d);
                }
            });
        });
        //Delete shift end





//form populatede

function populateForm(data){
            $("#shift_name").val(data.shift_name);
            $("#session_id").val(data.session_id);
            $("#class_id").val(data.class_id);
            $("#active_id").val(data.active_id);

            $("#examid").val(data.id);
            $("#addBtn").val('Update');


        }
        function clearform(){
            $('#ccccc')[0].reset();
            $("#addBtn").val('Save Exam');
        }

$(".close").click(function(){
  clearform();
});

// academy onchange
var url = "<?php echo e(URL::to('/')); ?>";
            $('select[name="session"]').on('change', function() {
                var sessionID = $(this).val();

                // alert(sessionID);return;
                if(sessionID) {
                    $.ajax({
                        url: url + '/admin/selectclass/'+sessionID,
                        //url: '/selectclass/'+sessionID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                           // console.log(data);

                            $('select[name="class"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="class"]').append('<option value="'+ value.id +'">'+ value.class_name +'</option>');
                            });


                        }
                    });
                }else{
                    $('select[name="class_name"]').empty();
                }
            });
            var url = "<?php echo e(URL::to('/')); ?>";
            $('select[name="class"]').on('change', function() {
                var classID = $(this).val();

                 //alert(classID);return;
                if(classID) {
                    $.ajax({
                        url: url + '/admin/selectshift/'+classID,
                        //url: '/selectclass/'+sessionID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                           // console.log(data);

                            $('select[name="shift"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="shift"]').append('<option value="'+ value.id +'">'+ value.shift_name +'</option>');
                            });


                        }
                    });
                }else{
                    $('select[name="shift_name"]').empty();
                }
            });


});

</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>