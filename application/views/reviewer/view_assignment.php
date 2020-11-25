<section id="intro">
<head>
<style>
#view_task {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#view_task td, #view_task th {
  border: 1px solid #ddd;
  padding: 8px;
}

#view_task tr:nth-child(even){background-color: #f2f2f2;}

#view_task tr:hover {background-color: #ddd;}

#view_task th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>
</head>
    <div class="jumbotron masthead">
      <div class="container">
          <h2>Your Assignment</h2>
          <table border="1", id="view_task">
            <tr>
              <th width="20px" style="text-align:center">No</th>
              <th width="220px" style="text-align:center">Title</th>
              <th width="220px" style="text-align:center">Author(s)</th>
              <th width="220px" style="text-align:center">Filename</th>
              <th width="220px" style="text-align:center">Page</th>
              <th width="220px" style="text-align:center">Date Submitted</th>
              <th width="220px" style="text-align:center">Deadline</th>
              <th width="220px" style="text-align:center">Status</th>
            </tr>

            <?php 
            $i=0;
            foreach ($assignments as $item) { 
            $i++; ?>
              <tr>
                <td style="text-align:center"><?php echo $i; ?></td>
                <td><?php echo $item['judul']; ?></td>
                <td><?php echo $item['authors']; ?></td>
                <td>
                  <a href="<?php echo base_url().'ApplicationCtl/download/'.$item['id_task'] ?>" target="_blank">
                    <?php echo $item['file_location']; ?>
                  </a></td>
                <td style="text-align:center"><?php echo $item['page']; ?></td>
                <td><?php echo date ("d M Y", strtotime($item['date_created'])); ?></td>
                <td><?php if($item['tgl_deadline']==NULL) {
                  echo "Not yet Assigned";
                  }else if ($item['status']==6) {?>
                  <a><span style="color:blue">Task Completed</span></a>
                  <?php } else {echo date ("d M Y", strtotime($item['tgl_deadline']));}?>
                </td>
                <td style="text-align:center">
                  <?php if($item['status']==1){ ?>
                    <a href="<?php echo site_url('reviewerCtl/accepted/' . $item['id_task']) ?>" class="badge badge-success">accept</a>
                    <a href="<?php echo site_url('reviewerCtl/rejected/' . $item['id_task']) ?>" class="badge badge-info">reject</a>
                  <?php } ?>
                  <?php if($item['status']==2){ ?>
                    <a><span style="color:green">Task Accepted</span></a></br>
                    <a href="<?php echo site_url('reviewerCtl/completeReviewTask/' . $item['id_task']) ?>" class="badge badge-success">Send Completed Task</a>
                  <?php } ?>
                  <?php if($item['status']==3) { ?>
                  <a><span style="color:red">Task rejected</span></a><?php } ?>
                  <?php if($item['status']==4) { ?>
                  <a><span style="color:blue">Completed, Waiting for Confirmation</span></a><?php } ?>
                  <?php if($item['status']==5) {echo "Waiting for Confirmation";}?>
                  <?php if($item['status']==6) {?>
                    <a href="<?php echo base_url().'ApplicationCtl/assignmentdownload/'.$item['id_assignment'] ?>" target="_blank">Completed</a>
                  <?php };?>
                </td>
                </tr>
            <?php } ?>
          </table>
        </div>
      </div>
    </div>
</section>