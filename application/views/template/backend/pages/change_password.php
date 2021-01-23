<div class="card">
  <div class="card-header">
     <form action='<?php echo base_url("c_change_password/change_password"); ?>' class='no_voucer_area' method="post" id=''>
      
      <?= $this->session->flashdata('notif') ?>
      <table>
        <tr>
          <th>Old Password</th><th> : </th>
          <th>
            <input type='password' class='form-control' placeholder='Old Password' name='password'>
          </th>
          
        </tr>

        <tr>
          <th>New Password</th><th> : </th>
          <th>
            <input type='password' class='form-control' placeholder='New Password' name='new_password'>
          </th>
          
        </tr>

        <tr>
          <th>Confirm New Password</th><th> : </th>
          <th>
            <input type='password' class='form-control' placeholder='Confirm New Password' name='new_passwordc'>
          </th>
          
        </tr>
        <tr>
          <th></th><th>  </th>
          <th>
            <input type='submit' class='btn btn-primary waves-effect waves-light '  value='Submit'>
          </th>
          
        </tr>
      </table>
      
      
    </form>
  </div>
  
</div>


<?php
//document.getElementById("password_edit").value

?>




<script type="text/javascript">
    


  function call_download()
  {
    var link_1 = document.getElementById("id_pilih_laporan").value;
    var link_2 = document.getElementById("date_from_laporan").value;
    var link_3 = document.getElementById("date_to_laporan").value;
    var slash = "/";

    var link = link_1.concat(link_2,slash, link_3);
    window.open(link);
  }

  
</script>

<script type="text/javascript">
    $(document).ready(function () {
      $('select').selectize({
          sortField: 'text'
      });
  });
</script>




<style type="text/css">
    div.searchable {
    width: 90%;
    margin: 0 15px;
}

.background-white
{
  background-color: white;
}
.background-blue
{
  background-color: #151B54;
  color: white;
}




.searchable input {
    width: 100%;
    height: 25px;
    font-size: 12px;
    padding: 10px;
    -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
    -moz-box-sizing: border-box; /* Firefox, other Gecko */
    box-sizing: border-box; /* Opera/IE 8+ */
    display: block;
    font-weight: 400;
    line-height: 1.6;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    background: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E") no-repeat right .75rem center/8px 10px;
}

.searchable ul {
    display: none;
    list-style-type: none;
    background-color: #fff;
    border-radius: 0 0 5px 5px;
    border: 1px solid #add8e6;
    border-top: none;
    max-height: 180px;
    margin: 0;
    overflow-y: scroll;
    overflow-x: hidden;
    padding: 0;
}

.searchable ul li {
    padding: 7px 9px;
    border-bottom: 1px solid #e1e1e1;
    cursor: pointer;
    color: #6e6e6e;
}

.searchable ul li.selected {
    background-color: #e8e8e8;
    color: #333;
}
</style>





<style type="text/css">
.text_red
{
  color: red;
}

.text_black
{
  color: black;
}
</style>