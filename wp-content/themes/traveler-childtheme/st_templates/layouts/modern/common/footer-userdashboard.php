<?php wp_footer(); ?>



<!-- Tariff delete box Modal -->
<div id="modDeleteConfirm" class="modal fade" tabindex="2" style="position:fixed; z-index:100000;margin-top:200px;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal">×</button>
					<span class="modal-title"><b>Delete Confirmation</b></span>
			</div>
			<div class="modal-body">
            <span id="spanTariffName"></span>
            <input type="hidden" name="txtTariffId" id="txtTariffId" value="" />
            </div>
			<div class="modal-footer">
                <button class="btn btn-default clsYesDelete" type="button">Yes</button>
                <button class="btn btn-primary clsNoDelete" type="button" data-dismiss="modal">No</button>
			</div>
			</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


</body>
</html>