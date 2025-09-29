<div class="modal fade" id="modal-tipo-material" tabindex="-1" aria-labelledby="modalTipoMaterialLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="form-tipo-material">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTipoMaterialLabel">
            <i class="fa-solid fa-plus me-2"></i>Novo Tipo de Material
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="novo_tipo_nome" class="form-label required">Nome do Tipo</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fa-solid fa-tag"></i></span>
              <input type="text" class="form-control" id="novo_tipo_nome" name="nome" required maxlength="100" placeholder="Digite o nome do tipo">
            </div>
            <div class="invalid-feedback" id="tipo-material-erro"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="fa-solid fa-xmark me-2"></i>Cancelar
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-save me-2"></i>Salvar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
