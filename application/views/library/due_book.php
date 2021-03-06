<script>
function confirmdelete(){
	var conf = confirm("Are you sure to delete this book?");
	 
	if(conf==true){
	}else{
		event.preventDefault();
	}
	
}
 
</script>

<div class="page-content">
	<div class="row-fluid">
		<div class="span12 page-header position-relative">
			<!--PAGE CONTENT BEGINS-->
			<a href="<?php echo base_url();?>library/issuedbook">
					<button class="btn btn-primary pull-right">
						<i class="icon-cogs bigger-125"></i>
						Manage Issued Books
					</button>
				</a>	
				<h1>
					<i class="icon-hand-right icon-animated-hand-pointer blue"></i>
					Due Issued Books
					<small>
						<i class="icon-double-angle-right"></i>
						Static &amp; Dynamic Tables
					</small>
				</h1>
		</div><!--/.page-header-->
		<div class="row-fluid">
			<div class="span12">
			<!--------------Message---------------------------------->
			<!--check any alert message or not -->
			 <?php
			 	if($this->session->flashdata('status_right')):
			 ?>
			 <!--Print Success Alert Message: -->
					<div class="alert alert-success no-margin">
						<button type="button" class="close" data-dismiss="alert">
							<i class="icon-remove red"></i>
						</button>
					
						<i class="icon-ok bigger-120 blue"></i>
						<?php echo $this->session->flashdata('status_right'); ?>
					</div>
			<?php endif; ?>
			<!--check any alert message or not -->
			 <?php
			 	if($this->session->flashdata('status_wrong')):
				
			 ?>
			 <!--Print Wrong Alert Message: -->		
					<div class="alert span12 alert-danger no-margin">
						<button type="button" class="close" data-dismiss="alert">
							<i class="icon-remove red"></i>
						</button>
					
						<div class="span1"><i class="icon-warning-sign icon-2x red"></i></div>
						<div class="span6"><?php echo $this->session->flashdata('status_wrong'); ?></div>
					</div>
				<?php endif; ?>	
			<!--------------End of Message---------------------------------->
				<!--PAGE CONTENT BEGINS-->
				<div class="row-fluid">
					 
					<div class="table-header">
						Results for "Latest Registered Classes"
					</div>

					<table id="sample-table-2" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th class="center">
									<label>
										<input type="checkbox" />
										<span class="lbl"></span>
									</label>
								</th>
								<th><h4 class="smaller blue"><i class="icon-user green"></i> | Issued For</h4></th>
								<th><h4 class="smaller blue"><i class="icon-book green"></i> | Book Details</h4></th>
								<th><h4 class="smaller blue"><i class="icon-calendar green"></i> | Issue Date</h4></th>
								<th><h4 class="smaller blue"><i class="icon-calendar green"></i> | Return Date</h4></th>
								<th><h4 class="smaller blue"><i class="icon-list green"></i> | Note</h4></th> 
								<th><h4 class="smaller blue"><i class=" icon-cog green"></i> | Options</h4></th>
							</tr>
						</thead>
						<?php 
					 
					$status=array('issued','available');
					foreach(@$book->result() as $row):
						?>		
						<tbody>
							<tr>
								<td class="center">
									<label>
										<input type="checkbox" />
										<span class="lbl"></span>
									</label>
								</td>
								<td><?php 
										if($row->userType==1){
											$this->db->select('*');
											$this->db->from('studentdetails');
											$this->db->join('studentinfo', 'studentinfo.StdDetailsId=studentdetails.Id');
											$this->db->join('classes', 'studentinfo.StdClassId=classes.Id');
											$this->db->where('studentinfo.StdDetailsId', $row->issueFor);
											$issFor = $this->db->get();
											foreach($issFor->result() as $item){
												echo $item->StdName.'<br/>';
												echo $item->ClassName.'<br/>';
												echo $item->StdRollNo;	
											}
										}else{
											$this->db->select('*');
											$this->db->from('employee');
											$this->db->join('departments', 'departments.Id=employee.EmployeeDeptId');
											$this->db->where('employee.ID', $row->issueFor);
											$issFor = $this->db->get();
											foreach($issFor->result() as $emp){
												echo $emp->EmployeeName.'<br/>';
												echo $emp->departmentName.'<br/>';
											 
											}
										}
										
								?></td>
								<td>
									<h4><?php echo @$row->name; ?></h4> 
									Author: <?php echo @$row->author;?> <br/>
									Details: <?php echo @$row->description; ?> <br/>
									Price: <?php echo @$row->price; ?>
								 </td>
								 <td><?php echo date('d-m-Y', strtotime($row->issuedate)); ?> </td>
								 <td><?php echo date('d-m-Y', strtotime($row->issueTill)); ?> </td> 
						 		<td><?php echo $row->note; ?> </td>
								<td class="td-actions">
									<div class="hidden-phone visible-desktop action-buttons">
										<a class="green" href="<?php echo base_url();?>library/updatebook/<?php echo $row->Id; ?>" data-rel="tooltip" data-placement="top" data-original-title="Edit Issue">
											<i class="icon-pencil bigger-130"></i>
										</a>
										<a class="green"  href="<?php echo base_url();?>library/returnbook/<?php echo $row->issueId; ?>" data-rel="tooltip" data-placement="top" data-original-title="Return Book">
											<i class=" icon-reply bigger-130"></i>
										</a>
										<a class="red" onclick="confirmdelete()" href="<?php echo base_url(); ?>library/deletebook/<?php echo $row->Id; ?>" data-rel="tooltip" data-placement="top" data-original-title="Delete Book">
											<i class="icon-trash bigger-130"></i>
										</a>
									</div>
									<div class="hidden-desktop visible-phone">
										<div class="inline position-relative">
											<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
												<i class="icon-caret-down icon-only bigger-120"></i>
											</button>
											<ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
												<li>
													<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
														<span class="green">
															<i class="icon-edit bigger-120"></i>
														</span>
													</a>
												</li>
												<li>
													<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
														<span class="red">
															<i class="icon-trash bigger-120"></i>
														</span>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</td>
							</tr>

							
						</tbody>
						<?php endforeach; ?>
					</table>
				</div>
 
						</div><!--/.span-->
		</div><!--/.row-fluid-->
				 
				
				  
			<!--PAGE CONTENT ENDS-->
		</div><!--/.span-->
	</div><!--/.row-fluid-->
</div><!--/.page-content-->
