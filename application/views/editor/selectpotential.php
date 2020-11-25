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
          <h2>List of Reviewer</h2>
          <table border="1", id="view_task">
            <tr>
              <th width="20px">No</th>
              <th width="220px">Name</th>
              <th width="220px">E-mail</th>
              <th width="220px">Skill</th>
              <th width="220px">Send Request!</th>
            </tr>

            <?php 
            $i=0;
            foreach ($reviewers as $item) { 
            $i++; ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $item['nama']; ?></td>
                <td><?php echo $item['email']; ?></td>
                <td><?php echo $item['kompetensi']; ?></td>
                <td><?php if($item['sts_reviewer']==TRUE){ ?>
                      <a href=<?php echo base_url().'managemytask/requestedtask/'.$id_task.'/'.$item['id_reviewer'];?>>
                        <span style="color:green">Available</span>
                      </a>
                    <?php }; ?>
                    <?php if($item['sts_reviewer']==FALSE) {?>
                      <a><span style="color:Red">Not Available</span>
                    <?php }; ?>
                </td>
              </tr>
            <?php } ?>
          </table>
        </div>
      </div>
    </div>
</section>