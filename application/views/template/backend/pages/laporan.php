<div class="card">
  <div class="card-header">
    <form action='<?php echo base_url("c_t_ak_jurnal_history/search_date"); ?>' class='no_voucer_area' method="post" id=''>

      <label>Pilih Laporan:</label>

      <select name="pilih_laporan" class='custom_width' id='id_pilih_laporan' placeholder='Pick a state...'>
        <?php

        $level_user_id = $this->session->userdata('level_user_id');
        if($level_user_id<8)
        {
          echo "<option value='laporan_excel/lap_cash_flow/index/' >Laporan Cash Flow</option>";
          echo "<option value='laporan_excel/lap_laba_rugi/index/' >Laporan Laba Rugi</option>";
          echo "<option value='laporan_excel/lap_neraca/index/' >Laporan Neraca</option>";
        }
          
          echo "<option value='laporan_excel/lap_po/index/' >Laporan PO</option>";
        
        
        ?>
      </select>
      <table>
        <tr>
          <th>Periode:</th>
          <th>
            <form action='/action_page.php'>
              <input type='date' class='form-control' id='date_from_laporan' value='<?php echo $this->session->userdata('date_from_select_jurnal'); ?>'>
          </th>
          <th>-</th>
          <th>
            <form action='/action_page.php'>
              <input type='date' class='form-control' id='date_to_laporan' value='<?php echo $this->session->userdata('date_to_select_jurnal'); ?>'>
          </th>
          <th>


            <button type='button' class='btn btn-success' onclick='call_download()'>Download</button>
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
  function call_download() {
    var link_1 = document.getElementById("id_pilih_laporan").value;
    var link_2 = document.getElementById("date_from_laporan").value;
    var link_3 = document.getElementById("date_to_laporan").value;
    var slash = "/";

    var link = link_1.concat(link_2, slash, link_3);
    window.open(link);
  }
</script>

<script type="text/javascript">
  $(document).ready(function() {
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

  .background-white {
    background-color: white;
  }

  .background-blue {
    background-color: #151B54;
    color: white;
  }




  .searchable input {
    width: 100%;
    height: 25px;
    font-size: 12px;
    padding: 10px;
    -webkit-box-sizing: border-box;
    /* Safari/Chrome, other WebKit */
    -moz-box-sizing: border-box;
    /* Firefox, other Gecko */
    box-sizing: border-box;
    /* Opera/IE 8+ */
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
  .text_red {
    color: red;
  }

  .text_black {
    color: black;
  }
</style>