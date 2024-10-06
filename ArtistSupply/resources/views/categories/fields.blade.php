<div class="form-group">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" name="nome" id="nome" value="{{ old('nome', $category->nome ?? '') }}" required>
</div>

<div class="form-group">
    <label for="descricao">Descrição</label>
    <textarea class="form-control" name="descricao" id="descricao">{{ old('descricao', $category->descricao ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="extra">Informações Extras</label>
    <input type="text" class="form-control" name="extra" id="extra" value="{{ old('extra', $category->extra ?? '') }}">
</div>
