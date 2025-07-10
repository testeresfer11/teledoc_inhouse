<!--RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment">
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span>
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Doctors</li><li><a href="doctor/doctors">Doctors</a></li>
    </ol>
    <!-- end breadcrumb -->

    <!-- You can also add more buttons to the
                ribbon for further usability

                Example below:

                <span class="ribbon-button-alignment pull-right">
                <span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
                <span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
                <span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
                </span> -->

</div>
<!-- END RIBBON -->

<!-- MAIN CONTENT -->
<div id="content">

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1 class="page-title txt-color-blueDark dashboard-title">
                <i class="fa fa-list-alt"></i>
                 List of Doctors
            </h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">

        </div>
    </div>


    <!--- update notification---->
    <?php $this->load->view('alert'); ?>

    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a href="doctor/doctors/create"><button class="btn btn-theme btn-success"><i class="fa fa-user-md custom"></i> New Doctor</button></a>
        </article>
    </div> 

    </br>


    <style>

    </style>


    <!-- widget grid -->
    <section id="widget-grid" class="reset-change">
        <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget jarviswidget-color-lightgray" data-widget-editbutton="true">
                    <!-- widget options:
                                usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

                                data-widget-colorbutton="false"
                                data-widget-editbutton="false"
                                data-widget-togglebutton="false"
                                data-widget-deletebutton="false"
                                data-widget-fullscreenbutton="false"
                                data-widget-custombutton="false"
                                data-widget-collapsed="true"
                                data-widget-sortable="false"

                                -->
                    <header>
                        <span class="widget-icon"> <i class="fa fa-list"></i> </span>
                        <h2>List of Doctors</h2>

                    </header>

                    <!-- widget div-->
                    <div class="employee-list doctors">

                        <!-- widget content -->
                        <div class="widget-body no-padding">
 <div class="table-responsive">
                            <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                <tr>
                                    <th data-hide="phone"><p>ID</p></th>
                                    <th data-class="expand"><p>Doctor Id</p></th>
                                    <!-- <th data-class="expand"><p>Registration Id</p></th> -->
                                    <th data-class="expand"><p>Name</p></th>
                                    <th data-hide="phone"><p>Mobile</p></th>
                                    <th data-hide="phone"><p>Email</p></th>
                                    <th data-class="expand"><p>RCC Number</p></th>
                                    <!-- <th>Created By</th>
                                    <th data-hide="phone,tablet">Last Update</th> -->
                                    <th data-hide="phone,tablet"><p>Status</p></th>
                                    <th data-hide="phone,tablet"><p>Approval Status</p></th>
                                    <th style="width:16%;"><p>Action</p></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php 
                                // prx($data);
                                $secretKey = '26kozQaKwRuNJ24t26kozQaKwRuNJ24t';
                                $uniqueDoctorIds = [];
                                $sl=1; 
                                foreach($data as $value){ 
                                    if (!in_array($value->doctor_id, $uniqueDoctorIds)) {
                                        // If not, add it to the array and display the row
                                        $uniqueDoctorIds[] = $value->doctor_id;
                                        ?>
                                        
                                    <tr>
                                        <td><?php echo $sl++; ?></td>
                                        <td><?php echo $value->doctor_id; ?></td>
                                       <!--  <td><?=empty($value->registeration_no) ? '' : AesCipher::decrypt($value->registeration_no); ?></td> -->
                                        <td><?php echo (string)AesCipher::decrypt($value->first_name); ?></td>
                                        <td><?php echo (string)AesCipher::decrypt($value->country_code).(string)AesCipher::decrypt($value->mobile_no); ?></td>
                                        <td><?php echo (string)AesCipher::decrypt($value->email); ?></td>
                                        <td><?=empty($value->rcc_no) ? 'NA' : AesCipher::decrypt($value->rcc_no); ?></td>
                                        <!-- <td><a target="_blank" href="welcome/employee_details/<?php echo $value->created_by; ?>"><?php echo $value->created_by; ?></a></td> -->
                                       <!--  <td><?php echo get_date_time($value->updated_time,'Y-m-d h:i:A'); ?></td> -->
                                        <td><?php echo $value->is_active==1?'Active':'Inactive'; ?></td>
                                         <td><?php echo $value->admin_approve==1?'Approved':'Unapproved'; ?></td>
                                        <td class="actions-btn-2">
                                            <p class="table-btns">
                                                <a data-toggle="tooltip" data-placement="top" title="Edit Commission" href="<?php echo base_url('doctor/doctors/add_commission/'.encrypt($value->user_id)); ?>"><button class="btn btn-info"><i class="fa fa-usd"></i></button></a> 
                                                <a data-toggle="tooltip" data-placement="top" title="View Details" href="doctor/doctors/view/<?php echo encrypt($value->user_id); ?>"><button class="btn btn-info"><i class="fa fa-eye"></i></button></a> 

                                                 <button value="<?= $value->user_id; ?>" class="btn btn-info deleteDoctor"><i class="fa fa-trash-o"></i></button>

                                                <?php if($value->admin_approve != 2){

                                                    ?>                                          
                                                    <a data-toggle="tooltip" data-placement="top" title="Reject" href="javascript:void(0);" onclick="showDoctorRejectModel(<?=$value->user_id ?>)"><button class="btn btn-danger"><i class="fa fa-ban"></i></button></a>
                                            <?php  }
                                            if($value->admin_approve != 1)
                                            {
                                                ?>
                                                <a data-toggle="tooltip" data-placement="top" title="Approve" href="doctor/doctors/status/<?php echo $value->doctor_id.'/'.'approve'; ?>"><button class="btn btn-success"><i class="fa fa-check"></i></button></a>
                                                <?php
                                            }
                                            ?>
                                            </p>
                                           <a data-toggle="tooltip" data-placement="top" title="edit doctor" href="<?php echo base_url('doctor/doctors/update/'.$value->user_id); ?>"><button class="btn btn-info"><i class="fa fa-pencil"></i></button></a>
                                        </td>
                                    </tr>
                                <?php }} ?>
                                </tbody>
                            </table>
  </div>
                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->

            </article>
            <!-- WIDGET END -->

        </div>

        <!-- end row -->

    </section>
    <!-- end widget grid -->

</div>
<!-- END MAIN CONTENT -->

<!-- Start Reject Model -->
  <div class="modal fade" id="exampleModal-reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="rejectForm" method="POST" action="<?=base_url() ?>doctor/doctors/rejectDoctor">
            <div class="custom-modal">
               <h3>Add Reason for Account rejection</h3>
               <textarea name="reject_reason" oninput="limit(this,100);" onpaste="limit(this,100);" class="form-control"  placeholder="Type You Reason Here"></textarea>
               <input type="hidden" name="doctor_id" id="rejectDoctor">
               <div class="reject-approve-btn-d">
                  <a href="javascript:$('#rejectForm').submit();" class="reject-btn">Reject</a>
                  <a href="javascript:void(0)" data-dismiss="modal" class="reapprove-btn">Cancel</a>
               </div>
            </div>
           </form>
         </div>
      </div>
   </div>
</div>
<!-- End Reject Model -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
       $('body').addClass("side-t");
 
       
});

//$("deleteCategory") deleteCategory(id){
$('.deleteDoctor').click(function(e){
     e.preventDefault();
     if (confirm('Are you sure You want to delete?')) {
        var id=$(this).val();
        $.ajax({
            type: "POST",
            url: 'doctor/doctors/deleteDoctor',
            data:{ user_id: id},
            success: function(response) {
                var data = JSON.parse(response);
                if(data.status=true){
                    toastr.success(data.message);
                    setInterval(function() {
                        location.reload();
                    }, 2000);
                }else{
                    toastr.error(data.message);
                }
              

            }
      });
    }
});
</script>