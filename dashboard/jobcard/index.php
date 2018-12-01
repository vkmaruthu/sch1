<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>


<?php error_reporting(0); ?>

<script type="text/javascript">
var Gcode=null;
var Gdate=null;
var Gfg=null;

var globalJobPOData=null;
var GJobCardData=null;
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalCRData=new Array();
var reasonTypeArray=new Array();
tempData.jobcard=
{
loadAllJobPO:function(data){
  debugger;
  var plantId = $('#plant_id').val();
  var customer_code=$('#cust_name').val();
  var requireDate=$('#userDateSel').val();
  var size_fg=$('#fg_code').val();
//alert(data);
if(data!=undefined){
  if(data==null){
          $('#confirmBtn').hide();
          $('#viewQRBtn').hide();
          $('#createReasonTable').DataTable({
             "paging":false,
              "ordering":true,
              "info":true,
              "searching":false,         
              "destroy":true,
          }).clear().draw();

        }else{

          $('#createReasonTable').DataTable({
             "paging":false,
              "ordering":true,
              "info":true,
              "searching":false,         
              "destroy":true,
          }).clear().draw();


            $('#viewQRBtn').hide();
            $('#confirmBtn').show();
    var DataTableProject = $('#createReasonTable').DataTable( {
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            "destroy":true,
            "data":data,   
            "columns": [    
              {data:null,"SlNo":false,className: "text-center"},
             /* { data: "requireDate"},*/
              { data: "batch_no",className: "text-right",
                render: function (data, type, row, meta) {
                  var str=row.batch_no;
                  var res=str.split("_");
                  return res[0];
                }
              },
              { data: "batch_no",className: "text-right",
                render: function (data, type, row, meta) {
                  var str=row.batch_no;
                  var res=str.split("_");
                  return res[2]+'/'+res[1];
                }
              },
              { data: "ord_qty",className: "text-right"},
              { data: "urgent",
                render: function (data, type, row, meta) {
                  var msg='';
                  var value=row.urgent;
                  if(value==null){
                    msg='Regular';
                  }else{
                    msg='Urgent';
                  }

                  return msg;
                }
              },
              { data: "siliconize",
                render: function (data, type, row, meta) {
                  var msg='';
                  var value=row.siliconize;
                  if(value==null){
                    msg='-';
                  }else{
                    msg='Silicon';
                  }

                  return msg;
                }
              },
              { data: "true_pass",
                render: function (data, type, row, meta) {
                  var msg='';
                  var value=row.true_pass;
                  if(value==null){
                    msg='-';
                  }else{
                    msg='Truepass';
                  }

                  return msg;
                }
              },
            /*  { data: "plan"},
              { data: "remarks"},
              { data: "customer_code"}*/
              ]
           });

           DataTableProject.on( 'order.dt search.dt', function () {
            DataTableProject.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw(); 

           } // else End here    //image_file_name

}else{
  //alert('Alert');
  var url="getDataController.php";
  var myData={getJobPoDetails:"getJobPoDetails", plant_id:plantId,customer_code:customer_code,requireDate:requireDate,size_fg:size_fg};
       $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType: 'json',
            data:myData,
            success: function(obj){
            globalJobPOData=obj.jobPoDetails;

        if(obj.jobPoDetails==null){
           $('#confirmBtn').hide();
           $('#viewQRBtn').hide();
          $('#createReasonTable').DataTable({
             "paging":false,
              "ordering":true,
              "info":true,
              "searching":false,         
              "destroy":true,
          }).clear().draw();

        }else{

          $('#total_qty').val(globalJobPOData[0].total_qty);
          $('#plan').val(globalJobPOData[0].plan);
          $('#plan_type').val(globalJobPOData[0].plan_code).change();
          $('#remarks').val(globalJobPOData[0].remarks);

          if(globalJobPOData[0].urgent == 0){
            $("#urgent").prop('checked',false);
          }else{
            $("#urgent").prop('checked',true);
          }

          if(globalJobPOData[0].siliconize == 0){
            $("#silicon").prop('checked',false);
          }else{
            $("#silicon").prop('checked',true);
          }

          if(globalJobPOData[0].true_pass == 0){
            $("#truepass").prop('checked',false);
          }else{
            $("#truepass").prop('checked',true);
          }

          $('#createReasonTable').DataTable({
             "paging":false,
              "ordering":true,
              "info":true,
              "searching":false,         
              "destroy":true,
          }).clear().draw();

            $('#confirmBtn').hide();
            $('#viewQRBtn').show();
    var DataTableProject = $('#createReasonTable').DataTable( {
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            "destroy":true,
            "data":obj.jobPoDetails,   
            "columns": [    
              {data:null,"SlNo":false,className: "text-center"},
             /* { data: "requireDate"},*/
              { data: "batch_no",className: "text-right",
                render: function (data, type, row, meta) {
                  var str=row.batch_no;
                  var res=str.split("_");
                  return res[0];
                }
              },
              { data: "batch_no",className: "text-right",
                render: function (data, type, row, meta) {
                  var str=row.batch_no;
                  var res=str.split("_");
                  return res[2]+'/'+res[1];
                }
              },
              { data: "ord_qty",className: "text-right"},
              { data: "urgent",
                render: function (data, type, row, meta) {
                  var msg='';
                  var value=row.urgent;
                  if(value==0){
                    msg='Regular';
                  }else{
                    msg='Urgent';
                  }

                  return msg;
                }
              },
              { data: "siliconize",
                render: function (data, type, row, meta) {
                  var msg='';
                  var value=row.siliconize;
                  if(value==0){
                    msg='-';
                  }else{
                    msg='Silicon';
                  }

                  return msg;
                }
              },
              { data: "true_pass",
                render: function (data, type, row, meta) {
                  var msg='';
                  var value=row.true_pass;
                  if(value==0){
                    msg='-';
                  }else{
                    msg='Truepass';
                  }

                  return msg;
                }
              },
            /*  { data: "plan"},
              { data: "remarks"},
              { data: "customer_code"}*/
              ]
           });

           DataTableProject.on( 'order.dt search.dt', function () {
            DataTableProject.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1; 
                } );
            } ).draw(); 

           } // else End here    //image_file_name

          } // ajax success ends
        });   
}

  },
  getCustomerDataDropdown:function(){
    var url="getDataController.php";
    var plant_id = $('#plant_id').val();
    var myData = {getCustomerDetails:'getCustomerDetails', plant_id:plant_id};
    $.ajax({
      type:"POST",
      url:url,
      async: false,
      dataType: 'json',
      cache: false,
      data:myData,
      success: function(obj) {
        if(obj.custData !=null){
           $("#cust_name").html('');
           $("#s_cust_name").html('');
            $("#cust_name").append('<option value="0"> Select Customer </option>');
            $("#s_cust_name").append('<option value="0"> Select Customer </option>');

            for(var i=0; i< obj.custData.length; i++){
             $("#cust_name").append('<option value='+obj.custData[i].cust_code+'>'+obj.custData[i].cust_name+'</option>'); 
             $("#s_cust_name").append('<option value='+obj.custData[i].cust_code+'>'+obj.custData[i].cust_name+'</option>'); 
            }
          }
        } 
    });
  },
  getSizeFgDropdown:function(){
    var url="getDataController.php";
    var plant_id = $('#plant_id').val();
    var myData = {getSizeFgDetails:'getSizeFgDetails', plant_id:plant_id};
    $.ajax({
      type:"POST",
      url:url,
      async: false,
      dataType: 'json',
      cache: false,
      data:myData,
      success: function(obj) {
        if(obj.sizeFgData !=null){
           $("#fg_code").html('');
           $("#s_fg_code").html('');
            $("#fg_code").append('<option value="0"> Select Size </option>');
            $("#s_fg_code").append('<option value="0"> Select Size </option>');
            for(var i=0; i< obj.sizeFgData.length; i++){
             $("#fg_code").append('<option value="'+obj.sizeFgData[i].fg_code+'">'+obj.sizeFgData[i].fg_code+'</option>'); 
             $("#s_fg_code").append('<option value="'+obj.sizeFgData[i].fg_code+'">'+obj.sizeFgData[i].fg_code+'</option>'); 
            }
          }
        } 
    });
  },
  getPlanTypeDropdown:function(){
    var url="getDataController.php";
    var plant_id = $('#plant_id').val();
    var myData = {getPlanTypeDetails:'getPlanTypeDetails', plant_id:plant_id};
    $.ajax({
      type:"POST",
      url:url,
      async: false,
      dataType: 'json',
      cache: false,
      data:myData,
      success: function(obj) {
        if(obj.planData !=null){
           $("#plan_type").html('');
            $("#plan_type").append('<option value="0"> Select Plan Type </option>');
            for(var i=0; i< obj.planData.length; i++){
             $("#plan_type").append('<option value="'+obj.planData[i].plan_code+'">'+obj.planData[i].plan_desc+'</option>'); 
            }
          }
        } 
    });
  },
confrimJobCard:function(){
  debugger;
      Gcode=null;
      Gdate=null;
      Gfg=null;

      var url="getDataController.php";
      var cust_name=$('#cust_name option:selected').text();

      var formEQData = new FormData($('#fromJobCard')[0]);
      formEQData.append("saveJobCard", "saveJobCard");
      formEQData.append("customer_name", cust_name);

      var customer_name=$('#cust_name').val();
      var size_fg=$('#fg_code').val();
      var plan_type = $('#plan_type').val();

        if(customer_name == 0) { 
          $('#msg').html('*Select Customer Name');
              return false;
        }else{
          $('#msg').html('');
            if(size_fg == 0) {
                $('#fg_code').css('border-color', 'red');
                return false;
            }else{
              $('#fg_code').css('border-color', '');
            }

            if($('#userDateSel').val() == "") {
                $('#userDateSel').css('border-color', 'red');
                return false;
            }else{
              $('#userDateSel').css('border-color', '');
            }

            if($('#total_qty').val() == "") {
                $('#total_qty').css('border-color', 'red');
                return false;
            }else{
              $('#total_qty').css('border-color', '');
            }

            if($('#plan').val() == "") {
                $('#plan').css('border-color', 'red');
                return false;
            }else{
              $('#plan').css('border-color', '');
            }

            if(plan_type == 0) {
                $('#plan_type').css('border-color', 'red');
                return false;
            }else{
              $('#plan_type').css('border-color', '');
            }

      $.ajax({
        type:"POST",
        url:url,
        async: false,
        dataType: 'json',
        cache: false,
        processData: false,
        contentType: false,
        data:formEQData,
        success: function(obj) {
          if(obj.data !=null){
            Gcode=$('#cust_name').val();
            Gdate=$('#userDateSel').val();
            Gfg=$('#fg_code').val();

            if(obj.data.infoRes=='C'){ // Already Created
              //$('#msg').html("<h3>*"+obj.data.info+"</h3>");
              $("#commonMsg").show();
                 $('#commonMsg').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.data.info+'</p>');
              tempData.jobcard.loadAllJobPO();
              //$('#viewQRBtn').show();
              return;
            }else{
              $('#msg').html('');
              if(obj.data.infoRes=='S'){ // 
                 $("#commonMsg").show();
                 $('#commonMsg').html('<p class="commonMsgSuccess"> <i class="fa fa-check"></i> '+obj.data.info+'</p>');
                 tempData.jobcard.loadAllJobPO();
                // tempData.jobcard.clearForm();

              }else{
                $("#commonMsg").show();
                 $('#commonMsg').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.data.info+'</p>');
              }  
            }
          } 
          setTimeout(function(){  
              $("#commonMsg").fadeToggle('slow');        
         }, 1500);

        }
      });
    }
},
 saveJobCard:function(){
  debugger;
      Gcode=null;
      Gdate=null;
      Gfg=null;

		  var url="getDataController.php";
      var customer_name=$('#cust_name option:selected').text();
      
		  var formEQData = new FormData($('#fromJobCard')[0]);
      formEQData.append("tempData", "tempData");
		  formEQData.append("customer_name", customer_name);

      var cust_name=$('#cust_name').val();      
		  var size_fg=$('#fg_code').val();
      var remarks = $('#remarks').val();
		  var plan_type = $('#plan_type').val();

		    if(cust_name == 0) { 
			    $('#msg').html('*Select Customer Name');
  		        return false;
		    }else{

		    	  $('#msg').html('');
            if(size_fg == 0) {
                //$('#fg_code').css('border-color', 'red');
                $('#msg').html('*Select Size');
                return false;
            }else{
              $('#fg_code').css('border-color', '');
            }

  			    if($('#userDateSel').val() == "") {
  			        $('#userDateSel').css('border-color', 'red');
  			        return false;
  			    }else{
  			    	$('#userDateSel').css('border-color', '');
    				}

            if($('#total_qty').val() == "") {
                $('#total_qty').css('border-color', 'red');
                return false;
            }else{
              $('#total_qty').css('border-color', '');
            }

            if($('#plan').val() == "") {
                $('#plan').css('border-color', 'red');
                return false;
            }else{
              $('#plan').css('border-color', '');
            }

            if($('#plan_type').val() == 0) {
                //$('#plan_type').css('border-color', 'red');
                 $('#msg').html('*Select Plan Type');
                return false;
            }else{
              $('#plan_type').css('border-color', '');
            }

		  $.ajax({
		    type:"POST",
		    url:url,
		    async: false,
		    dataType: 'json',
		    cache: false,
		    processData: false,
		    contentType: false,
		    data:formEQData,
		    success: function(obj) {
		      if(obj.data !=null){
            Gcode=$('#cust_name').val();
            Gdate=$('#userDateSel').val();
            Gfg=$('#fg_code').val();

            if(obj.data.infoRes=='T'){
              //$('#msg').html("*"+obj.data.info);
              $("#commonMsg").show();
                 $('#commonMsg').html('<p class="commonMsgSuccess"> <i class="fa fa-check"></i> '+obj.data.info+'</p>');
              tempData.jobcard.loadAllJobPO(obj.data.tempData);
              setTimeout(function(){  
                 $("#commonMsg").fadeToggle('slow');        
              }, 1500);
              return;
            }

            if(obj.data.infoRes=='C'){
              //$('#msg').html("<h3>*"+obj.data.info+"</h3>");
              $("#commonMsg").show();
                 $('#commonMsg').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.data.info+'</p>');
              tempData.jobcard.loadAllJobPO();
              return;
            }else{
              $('#msg').html('');
  		        if(obj.data.infoRes=='S'){
  		           $("#commonMsg").show();
  		           $('#commonMsg').html('<p class="commonMsgSuccess"> <i class="fa fa-check"></i> '+obj.data.info+'</p>');
  		           tempData.jobcard.loadAllJobPO();
  		           tempData.jobcard.clearForm();

  		        }else{
  		          $("#commonMsg").show();
  		           $('#commonMsg').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.data.info+'</p>');
  		        }  
            }
		      } 
		      setTimeout(function(){  
			        $("#commonMsg").fadeToggle('slow');        
			   }, 1500);

		    }
		  });
	  }
},
viewQRCode:function ()
{
  var customer_code=Gcode;
  var requireDate=Gdate;
  var size_fg=Gfg;

  params  = 'width='+window.outerWidth;
  params += ', height='+window.outerHeight;
  params += ', top=0, left=0'
  params += ', fullscreen=yes,scrollbars: 0';
   
   var baseUrl ="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dashboard/jobcard/jobQRcode.php?code="+customer_code+"&date="+requireDate+"&fg="+size_fg;

   window.open(baseUrl, "MsgWindow", params);

},
reload:function(){
	location.reload(true);
},
searchClearJobCard:function(){  
  $('#s_cust_name').val(0).change();  
  $('#s_fg_code').val(0).change();  
  $("#searchJobCardID").fadeToggle("slow");
  $("#msgQty").html(''); 
  $("#msg").html('');  
  tempData.jobcard.loadSearchTable();
},
clearForm:function(){
    $('#cust_name').val(0).change();  
    $('#fg_code').val(0).change();  
    $("#generateJobCard").fadeToggle("slow");
    $('#fromJobCard')[0].reset();
    $("#addJobCard").show();
    $("#updateReason").hide(); 
    $("#record_id").val('');
    $("#urgent").removeAttr('checked');
    $("#silicon").removeAttr('checked');

     $("#commonMsg").fadeOut('slow');   
     $("#msg").html('');   
     $("#msgQty").html('');
    tempData.jobcard.loadAllJobPO();
},
getQtyVal:function(val){
  $('#msgQty').html('');
  var totalQty=val*12;
  $('#msgQty').html('Total Qty : <b>'+totalQty+'</b>');
},
getSearchData:function(){
    var url="getDataController.php";
    var plant_id = $('#plant_id').val();
    var customer_name=$('#s_cust_name').val();
    var size_fg=$('#s_fg_code').val();
    var s_to=$('#s_to').val();
    var s_from=$('#s_from').val();
    var myData = {getSearchData:'getSearchData', plant_id:plant_id,customer_name:customer_name,size_fg:size_fg,s_to:s_to,s_from:s_from};

    $.ajax({
      type:"POST",
      url:url,
      async: false,
      dataType: 'json',
      cache: false,
      data:myData,
      success: function(obj) {
        GJobCardData=null;
           GJobCardData = obj.jobPoDetails;
           tempData.jobcard.loadSearchTable(obj.jobPoDetails);
        } 
    });
  },
loadSearchTable:function(data){
  if(data==null){
          $('#searchDataTable').DataTable({
             "paging":false,
              "ordering":true,
              "info":true,
              "searching":false,         
              "destroy":true,
          }).clear().draw();

        }else{

          $('#searchDataTable').DataTable({
             "paging":false,
              "ordering":true,
              "info":true,
              "searching":false,         
              "destroy":true,
          }).clear().draw();

    var searchDataTable = $('#searchDataTable').DataTable( {
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            "destroy":true,
            "data":data,   
            "columns": [    
              {data:null,"SlNo":false,className: "text-center"},
              { data: "id",className: "text-center",
                render: function (data, type, row, meta) {
                  var view='<button type="button" title="View" class="btn btn-success btn-xs" onclick="tempData.jobcard.viewCard(\''+row.batch_no+'\');">View </button>';
                  return view;
                }
              },//addOneDate
              //{ data: "requireDate"}, 
              { data: "req_date",className: "text-left",
                render: function (data, type, row, meta) {
                  var date=tempData.jobcard.addOneDate(row.req_date);
                  return date;
                }
              },             
              { data: "cust_name"},
              { data: "total_qty",className: "text-right",
                render: function (data, type, row, meta) {
                  var str=row.total_qty*12;
                  return str;
                }
              },
              { data: "fg_code",className: "text-left"},
              { data: "urgent",
                render: function (data, type, row, meta) {
                  var msg='';
                  var value=row.urgent;
                  if(value=="0"){
                    msg='Regular';
                  }else{
                    msg='Urgent';
                  }

                  return msg;
                }
              },
              { data: "siliconize",
                render: function (data, type, row, meta) {
                  var msg='';
                  var value=row.siliconize;
                  if(value=="0"){
                    msg='-';
                  }else{
                    msg='Siliconize';
                  }

                  return msg;
                }
              },
              { data: "true_pass",
                render: function (data, type, row, meta) {
                  var msg='';
                  var value=row.true_pass;
                  if(value=="0"){
                    msg='-';
                  }else{
                    msg='Truepass';
                  }

                  return msg;
                }
              },
              { data: "plan"},
              { data: "remarks"},
              
              ]
           });

           searchDataTable.on( 'order.dt search.dt', function () {
            searchDataTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw(); 

           } // else End here    //image_file_name
},
viewCard:function(batch_no){  
  var objJson=tempData.jobcard.getObjects(GJobCardData,'batch_no',batch_no);
  var customer_code=objJson[0].cust_code;
  var requireDate=objJson[0].req_date;
  var size_fg=objJson[0].fg_code;
  var plant_id = $('#plant_id').val();

  var url="getDataController.php";
    var myData = {getViewJobCardData:'getViewJobCardData', customer_code:customer_code,requireDate:requireDate,size_fg:size_fg,plant_id:plant_id};
      $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType: 'json',
            data:myData,
            success: function(obj){
            globalJobPOData=obj.jobPoDetails;

        if(obj.jobPoDetails==null){
           $('#confirmBtn').hide();
           $('#viewQRBtn').hide();
          $('#createReasonTable').DataTable({
             "paging":false,
              "ordering":true,
              "info":true,
              "searching":false,         
              "destroy":true,
          }).clear().draw();

        }else{
          $("#searchJobCardID").fadeToggle("slow");
          $("#generateJobCard").fadeToggle("slow");

            Gcode=globalJobPOData[0].cust_code;
            Gdate=tempData.jobcard.addOneDate(globalJobPOData[0].req_date);
            Gfg=globalJobPOData[0].fg_code;

          $('#cust_name').val(globalJobPOData[0].cust_code).change();
          $('#fg_code').val(globalJobPOData[0].fg_code).change();
          $('#userDateSel').val(tempData.jobcard.addOneDate(globalJobPOData[0].req_date));
          $('#total_qty').val((globalJobPOData[0].total_qty)/12);
          $('#plan').val(globalJobPOData[0].plan);
          $('#plan_type').val(globalJobPOData[0].plan_code).change();
          $('#remarks').val(globalJobPOData[0].remarks);

          $('#msgQty').html('');
          var totalQty=(globalJobPOData[0].total_qty);
          $('#msgQty').html('Total Qty : <b>'+totalQty+'</b>');

          if(globalJobPOData[0].urgent == 0){
            $("#urgent").prop('checked',false);
          }else{
            $("#urgent").prop('checked',true);
          }

          if(globalJobPOData[0].siliconize == 0){
            $("#silicon").prop('checked',false);
          }else{
            $("#silicon").prop('checked',true);
          }

          if(globalJobPOData[0].true_pass == 0){
            $("#truepass").prop('checked',false);
          }else{
            $("#truepass").prop('checked',true);
          }

          $('#createReasonTable').DataTable({
             "paging":false,
              "ordering":true,
              "info":true,
              "searching":false,         
              "destroy":true,
          }).clear().draw();

            $('#confirmBtn').hide();
            $('#viewQRBtn').show();
    var DataTableProject = $('#createReasonTable').DataTable( {
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            "destroy":true,
            "data":obj.jobPoDetails,   
            "columns": [    
              {data:null,"SlNo":false,className: "text-center"},
             /* { data: "requireDate"},*/
              { data: "batch_no",className: "text-right",
                render: function (data, type, row, meta) {
                  var str=row.batch_no;
                  var res=str.split("_");
                  return res[0];
                }
              },
              { data: "batch_no",className: "text-right",
                render: function (data, type, row, meta) {
                  var str=row.batch_no;
                  var res=str.split("_");
                  return res[2]+'/'+res[1];
                }
              },
              { data: "ord_qty",className: "text-right"},
              { data: "urgent",
                render: function (data, type, row, meta) {
                  var msg='';
                  var value=row.urgent;
                  if(value==0){
                    msg='Regular';
                  }else{
                    msg='Urgent';
                  }

                  return msg;
                }
              },
              { data: "siliconize",
                render: function (data, type, row, meta) {
                  var msg='';
                  var value=row.siliconize;
                  if(value==0){
                    msg='-';
                  }else{
                    msg='Silicon';
                  }

                  return msg;
                }
              },
              { data: "true_pass",
                render: function (data, type, row, meta) {
                  var msg='';
                  var value=row.true_pass;
                  if(value==0){
                    msg='-';
                  }else{
                    msg='Truepass';
                  }

                  return msg;
                }
              },
            /*  { data: "plan"},
              { data: "remarks"},
              { data: "customer_code"}*/
              ]
           });

           DataTableProject.on( 'order.dt search.dt', function () {
            DataTableProject.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw(); 

           } // else End here    //image_file_name

          } // ajax success ends
        }); 

},
getObjects:function(obj, key, val) {  // JSON Search function
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(tempData.jobcard.getObjects(obj[i], key, val));
        } else if (i == key && obj[key] == val) {
            objects.push(obj);
        }
    }
    return objects;    
},
addOneDate:function(date){
  //var dt=dateTime.split(' ');
  var onlyDate=date.split('-');
  return onlyDate[2]+'/'+onlyDate[1]+'/'+onlyDate[0];
},

};

$(document).ready(function() {
    debugger;
    $("#menuJobCardScreen").parent().addClass('active');
    $("#menuJobCardScreen").parent().parent().closest('.treeview').addClass('active menu-open');

var date = new Date();
date.setDate(date.getDate());

  var setDateFormat="dd/mm/yyyy";
  $('#userDateSel').datepicker({
      format: setDateFormat,
      autoclose: true,
      startDate:date
  });

  $('#plan').datepicker({
    format: "MM-yyyy",
    viewMode: "months", 
    minViewMode: "months",
    startDate:date
  });

  var setDateFormat="dd/mm/yyyy";
  $('#s_to').datepicker({
      format: setDateFormat,
      autoclose: true,
  });

  var setDateFormat="dd/mm/yyyy";
  $('#s_from').datepicker({
      format: setDateFormat,
      autoclose: true,
  });

  // Date initialization Jobcard 
  var date = new Date();
  var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
  

    //$('#comp_id').val(<?php echo $_GET['comp_id'];?>);
    $('#plant_id').val(<?php echo $_GET['plant_id'];?>);
  //  $('#wc_id').val(<?php echo $_GET['wc_id'];?>);
    $('#color').css('background-color','#b2ba62');    

    // $('#s_comp_id').val(<?php// echo $_GET['comp_id'];?>);
    // $('#s_plant_id').val(<?php //echo $_GET['plant_id'];?>);
    // $('#s_wc_id').val(<?php //echo $_GET['wc_id'];?>);
    // $('#s_color').css('background-color','#b2ba62');
 	

  $('.select2').select2();
  $("#searchJobCardID").hide();
  $("#generateJobCard").hide();
  $('#commonMsg').hide();
  
 tempData.jobcard.getCustomerDataDropdown();
 tempData.jobcard.getSizeFgDropdown();
 tempData.jobcard.getPlanTypeDropdown();

 $('#createReasons').click(function(){
    $('#searchJobCardID').hide();
   	tempData.jobcard.clearForm();  
    $('#userDateSel').datepicker('setDate', today);
    $('#plan').datepicker('setDate', today);
 });

$('#searchJobCard').click(function(){
  $('#generateJobCard').hide();
  tempData.jobcard.searchClearJobCard();
  $('#s_to').datepicker('setDate', today);
  $('#s_from').datepicker('setDate', today);
});

 $('#reason_type_id').change(function(){
     $('#msg').html('');
  });
 $('#s_cancel').click(function(){
  tempData.jobcard.searchClearJobCard();
 });

 $('#cancel').click(function(){
 	tempData.jobcard.clearForm();
 });

tempData.jobcard.loadAllJobPO();
tempData.jobcard.loadSearchTable();

  /*$('#record_id').val('');
  if($('#comp_id').val() != "" && $('#wc_id').val() != ""){
 	$('#back').show();
  }else{
  	 $('#back').hide();
  }
  $('#reason_code_no').keyup(function(){
	  $('#reason_code_no').css('border-color', '');
  });
  $('#message').keyup(function(){
	  $('#message').css('border-color', '');
  });*/
});

</script>

<style type="text/css">
  .checkboxCss{
    height: 19px;
    width: 19px;
  }
</style>

  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
        <div class="col-md-10 col-sm-12 col-xs-10 pull-left headerTitle" >
        <h3 style="margin-top: 2px;">Generate Job Card<h3>
        </div>
      </div>

    <div class="panel panel-default">
      <div class="panel-heading "> 
        <button type="button" onclick="tempData.jobcard.reload();" class="btn btn-sm btn-info pull-right" style="margin-top: -3px;margin-bottom: -2px;margin-left:15px;">   <i class="fa  fa-refresh"> </i>
        </button>
        <button type="button" id="createReasons" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Generate Job Card
        </button>
        <button type="button" id="searchJobCard" class="btn btn-sm btn-warning pull-right" style="margin-top: -3px;margin-bottom: -2px;margin-right: 1%;">
              <i class="fa fa-search"></i>&nbsp; Search Job Card
        </button>
        
          <div class="clearfix"></div>
      </div>   
      <div class="panel-body">
        <div class="row" id="generateJobCard">
          <div class="col-md-12"> 
          <div id="status" class="alert alert-success" style="color:green;text-align:center;font-weight:600;display:none;"></div>
          <div id="error" class="alert alert-danger" style="color:white;text-align:center;font-weight:600;display:none;"></div>
          
        <div id="delCommonMsg"> </div>  
        <div id="commonMsg"> </div>
        <form class="" id="fromJobCard">  
          <!-- <input type="hidden" name="comp_id" id="comp_id"/>  -->
          <input type="hidden" name="record_id" id="record_id"/> 
          <input type="hidden" name="plant_id" id="plant_id"/>
          <!-- <input type="hidden" name="wc_id" id="wc_id"/>             -->
            <div class="form-group">
             <div class="row">   
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12"> Customer <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <select class="form-control select2"  id="cust_name" name="cust_name">
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-6">
                   <label class="control-label col-md-4 col-sm-6 col-xs-12">Required Date <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class='col-md-12 input-group date datepicker-me'>
                      <input type='text' class="form-control" id='userDateSel' name="userDateSel" 
                             style="cursor: pointer;" readonly="readonly"/>
                        <label class="input-group-addon btn" for="userDateSel">
                            <span class="glyphicon glyphicon-calendar"></span>               
                        </label>
                    </div>
                    </div>
                </div>

              </div>
              
             <div class="row">
                <div class="col-md-6">
                   <label class="control-label col-md-4 col-sm-6 col-xs-12">Size <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <select class="form-control select2"  id="fg_code" name="fg_code">
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Total Quantity 
                     <sub> (Dozen) </sub><span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" name="total_qty" id="total_qty" placeholder="Total Quantity" 
                      class="form-control" required="true" min="0" oninput ="this.value = Math.abs(this.value)" onkeyup="tempData.jobcard.getQtyVal(this.value);"/>
                      <p style="font-size: 13px;margin-top: 1%;" id="msgQty"></p>
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                   <label class="control-label col-md-4 col-sm-6 col-xs-12">Plan <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class='col-md-12 input-group date'>
                      <input type="text" name="plan" id="plan" placeholder="Plan" 
                      class="form-control" required="true" style="cursor: pointer;" readonly="readonly"/>
                       <label class="input-group-addon btn" for="plan">
                            <span class="glyphicon glyphicon-calendar"></span>               
                        </label>
                    </div>
                    </div>
                </div>
               
                <div class="col-md-6">
                   <label class="control-label col-md-4 col-sm-6 col-xs-12">Plan Type <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <select class="form-control select2"  id="plan_type" name="plan_type">
                        </select>
                      </div>
                    </div>
                </div>

              </div>

              <div class="row" style="margin-top: 1%;">
               
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Remarks</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                       <textarea class="form-control" placeholder="Remarks" rows="2" id="remarks" 
                       name="remarks" maxlength="80"></textarea>
                    </div>
                </div>

                <div class="col-md-2 col-xs-12">                
                    <div class="col-md-1 col-sm-1 col-xs-1">
                      <input type="checkbox" class="checkboxCss" name="urgent" id="urgent" required="true"/>
                    </div>
                      <label class="control-label col-md-4 col-sm-6 col-xs-10">Urgent</label>
                </div>

                 <div class="col-md-2 col-xs-12">
                   
                    <div class="col-md-1 col-sm-1 col-xs-1">
                       <input type="checkbox" class="checkboxCss" name="silicon" id="silicon" required="true"/>
                    </div>
                    <label class="control-label col-md-4 col-sm-6 col-xs-10">Siliconize</label>
                </div>

                <div class="col-md-2 col-xs-12">
                   
                    <div class="col-md-1 col-sm-1 col-xs-1">
                       <input type="checkbox" class="checkboxCss" name="truepass" id="truepass" required="true"/>
                    </div>
                    <label class="control-label col-md-5 col-sm-6 col-xs-10">Truepass</label>
                </div>

              </div>
              <br/>
              <div class="row">
               <div id="msg" style="padding-left: 28px;color: red;"></div>
                   <div class="col-md-12 text-center">
                    <button type="button" id="addJobCard" onclick="tempData.jobcard.saveJobCard();"  class="btn btn-sm btn-success">
                      <i class="fa fa-floppy-o"></i>&nbsp; Submit
                    </button>
                     <button type="button" id="cancel" onclick="" class="btn btn-sm btn-danger"><i class="fa fa-close"></i>&nbsp; Cancel
                    </button>
                   </div>
              </div>
            </div>  
           <hr class="hr-primary"/>  
          </form>

      <div class="table-responsive"> 
          <table id="createReasonTable" class="table table-hover table-bordered nowrap" style="font-size: 12px;width:100%;">
           <thead>
             <tr>
              <th>Sl.No</th>
             <!--  <th>Required Date</th> -->
              <th>B.C No.</th>
              <th>S.C No.</th>
              <th>S.T Qty</th>
              <th>Urgent</th>
              <th>Siliconize</th>
              <th>Truepass</th>
              <!-- <th>Plan</th>
              <th style="width: 20%;">Remarks</th>
              <th>Customer</th> -->
             
             </tr>
           </thead>
           </table>
      <div class="text-center">
        <button type="button" id="confirmBtn" onclick="tempData.jobcard.confrimJobCard();"  
        class="btn btn-lg btn-success" style="display: none;">
          <i class="fa fa-check-circle-o"></i>&nbsp; Confirm  </button>

          <button type="button" id="viewQRBtn" onclick="tempData.jobcard.viewQRCode();"  
        class="btn btn-lg btn-primary" style="display: none;">
          <i class="fa fa-qrcode"></i>&nbsp; View Job Card  </button>

      </div>
    

         </div>
      </div>
    </div>

    <div class="row" id='searchJobCardID'>
      <div class="container"> 
          <form id="searchForm">         
            <div class="form-group">
             <div class="row">   
               
                <div class="col-md-8">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12">Required Date </label>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class='col-md-12 input-group date datepicker-me'>
                      <input type='text' class="form-control" id='s_from' name="s_from" 
                             style="cursor: pointer;" readonly="readonly"/>
                        <label class="input-group-addon btn" for="s_from">
                            <span class="glyphicon glyphicon-calendar"></span>               
                        </label>
                    </div>
                    </div>

                    <div class="col-md-1 col-sm-1 col-xs-12">
                      <b>TO</b>
                    </div>  
                    
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <div class='col-md-12 input-group date datepicker-me'>
                      <input type='text' class="form-control" id='s_to' name="s_to" 
                             style="cursor: pointer;" readonly="readonly"/>
                        <label class="input-group-addon btn" for="s_to">
                            <span class="glyphicon glyphicon-calendar"></span>               
                        </label>
                    </div>                    
                    </div>

                </div>
              </div>

              <div class="row" style="margin-top: 2%;">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12"> Customer </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <select class="form-control select2"  id="s_cust_name" name="s_cust_name">
                        </select>
                      </div>
                    </div>
                </div>

                <div class="col-md-6">
                   <label class="control-label col-md-4 col-sm-6 col-xs-12">Size </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <select class="form-control select2"  id="s_fg_code" name="s_fg_code">
                        </select>
                      </div>
                    </div>
                </div>
              </div>
                
              <div class="col-md-12 text-center">
                  <button type="button" id="s_addJobCard" onclick="tempData.jobcard.getSearchData();"  class="btn btn-sm btn-success">
                    <i class="fa fa-search"></i>&nbsp; Search
                  </button>
                   <button type="button" id="s_cancel" onclick="" class="btn btn-sm btn-danger"><i class="fa fa-close"></i>&nbsp; Cancel
                  </button>
              </div>
              
              </div>              
          </form>
        </div>
      <div class="col-sm-12" style="margin-top: 3%;"> 
        <div class="table-responsive"> 
          <table id="searchDataTable" class="table table-hover table-bordered" style="font-size: 12px;width:100%;">
           <thead>
             <tr>
              <th>Sl.No</th>
              <th>Action</th>
              <th>Required Date</th>              
              <th>Customer</th>
              <!-- <th>B.C No.</th>
              <th>S.C No.</th> -->
              <th>Total Qty</th>
              <th>Size</th>
              <th>Urgent</th>
              <th>Siliconize</th>
              <th>Truepass</th>
              <th>Plan</th>
              <th style="width: 25%;">Remarks</th>
             
             </tr>
           </thead>
           </table>
        </div> 
        </div> 


      </div>  
    </div>
      
   </div>       
   </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php //include('../common/footer.php'); ?>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <!-- <div class="control-sidebar-bg"></div> -->
</div>
<!-- ./wrapper -->

</body>
</html>
