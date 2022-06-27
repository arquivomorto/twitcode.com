<!-- Simple modal dialog containing a form -->
<dialog id="dialogMessage">
    <a class="close-dialog-btn" href="javascript:messageCloseDialog();">X</a>
    <form id="frmMessage">
        <label for="message"><?php __("Mensagem");?></label>
        <textarea name="message" id="message" cols="30" rows="10"></textarea><br>
        <button type="submit">
            <?php __('Enviar');?>
        </button>
    </form>
</dialog>