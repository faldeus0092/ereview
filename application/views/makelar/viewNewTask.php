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
          <h2>List of New Tasks</h2>
          <?php if (sizeof($tasks)==0){?>
              <div class="alert alert-danger" role="alert">Currently no New Task to Display</div> 
          <?php } else { ?>
          <table border="1", id="view_task">
            <tr>
              <th width="20px" style="text-align:center">No</th>
              <th width="220px" style="text-align:center">Title</th>
              <th width="220px" style="text-align:center">Keywords</th>
              <th width="220px" style="text-align:center">Filename</th>
              <th width="220px" style="text-align:center">Page Count</th>
              <th width="220px" style="text-align:center">Date Submitted</th>
              <th width="220px" style="text-align:center">Requested to</th>
            </tr>

            <?php 
            $i=0;
            foreach ($tasks as $item) { 
            $i++; ?>
              <tr>
                <td style="text-align:center"><?php echo $i; ?></td>
                <td><?php echo $item['judul']; ?></td>
                <td><?php echo $item['katakunci']; ?></td>
                <td><a href="<?php echo base_url().'ApplicationCtl/download/'.$item['id_task'] ?>" target="_blank"><?php echo $item['file_location']; ?></a></td>
                <td style="text-align:center"><?php echo $item['page']; ?></td>
                <td><?php echo date ("d M Y", strtotime($item['date_created'])); ?></td>
                <td><?php echo $item['nama']; ?></td>
              </tr>
            <?php } ?>
          </table>
            <?php } ?>
        </div>
      </div>
    </div>
</section>