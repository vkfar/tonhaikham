<div style="padding: 20px;">
    <h4>Report Income</h4>
    <ol class="breadcrumb" style="margin-bottom: 5px;">
         <li><a href="backoffice.php">Tonhaikham</a></li>
        <li><a href="report.php">Report</a></li>
        <li><a href="report.php?page=income">Report Income</a></li>
    </ol>
    <div>
        <div class="col-lg-6">
            <br>
            <form role="form">
                <div class="form-group">
                    <label>From:</label>   
                    <div class="input-group date" id="datetimepicker4">
                        <input type="text" class="form-control startTime1" data-startend="start" data-startendelem=".endTime1" data-max="<?= date("d-m-Y"); ?>" id="txt-memstart" value="" data-field="date" readonly style="cursor: pointer"/>
                        <div id="dtBoxe"></div>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    <label>To:</label>
                    <div class="input-group date" id="datetimepicker4">
                        <input type="text" class="form-control endTime1"  id="txt-memex" data-startend="end" data-startendelem=".startTime1" data-max="<?= date("d-m-Y"); ?>" value="" data-field="date" readonly style="cursor: pointer"/>
                        <div id="dtBoxe2"></div>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div><br>
                    <input type="checkbox" class="ch_bill_detail">  <label>Show bill detail </label><br><br>
                    <br>
                    <input type="button" class="btn-sm btn-primary" value="Preview" id="btn_pdf_income">
                </div>
            </form>
         
        </div>
        <div class="clearfix"></div>
    </div>
    <br>
    <iframe class="box-preview-report" width="100%" style="height: 800px;display: none" src=""></iframe>
</div>
