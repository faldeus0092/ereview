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
          <h2>List of Requested Tasks</h2>
          <?php if (sizeof($tasks)==0){?>
              <div class="alert alert-danger" role="alert">Currently no Paid Task to Display</div> 
          <?php } else { ?>
          <p><span style="color:red">Please check both payment's proof and file before completing task<span></a>
          <table border="1", id="view_task">
            <tr>
              <th width="20px" style="text-align:center">No</th>
              <th width="220px" style="text-align:center">Title</th>
              <th width="220px" style="text-align:center">Proof</th>
              <th width="220px" style="text-align:center">Completed File</th>
              <th width="100px" style="text-align:center">Page Count</th>
              <th width="220px" style="text-align:center">Date Completed</th>
              <th width="220px" style="text-align:center">Reviewer</th>
              <th width="220px" style="text-align:center">Action</th>
            </tr>

            <?php 
            $i=0;
            foreach ($tasks as $item) { 
            $i++; ?>
              <tr>
                <td style="text-align:center"><?php echo $i; ?></td>
                <td><?php echo $item['judul']; ?></td>
                <td><a href="<?php echo base_url().'ApplicationCtl/buktiDownload/'.$item['id_assignment'] ?>" target="_blank"><?php echo $item['bukti']; ?></a></td>
                <td><a href="<?php echo base_url().'ApplicationCtl/assignmentDownload/'.$item['id_assignment'] ?>" target="_blank"><?php echo $item['file_location']; ?></a></td>
                <td style="text-align:center"><?php echo $item['page']; ?></td>
                <td><?php echo date ("d M Y", strtotime($item['date_updated'])); ?></td>
                <td><?php echo $item['nama']; ?></td>
                <td style="text-align:center">
                  <?php if($item['status']==5){ ?>
                    <a href="<?php echo site_url('makelarCtl/accepted/' . $item['id_task'].'/'.$item['id_reviewer'].'/'.$item['id_assignment']) ?>" class="badge badge-success">accept</a>
                    <a href="<?php echo site_url('makelarCtl/rejected/' . $item['id_task']) ?>" class="badge badge-info">reject</a>
                  <?php } ?>
                </td>
              </tr>
            <?php } ?>
          </table>
          <?php } ?>
        </div>
      </div>
    </div>
</section>