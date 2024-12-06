<div class="form-group">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" name="nome" id="nome" value="{{ old('nome', $order->nome ?? '') }}" required>
</div>

<div class="form-group">
    <label for="quantia">Quantia</label>
    <input type="number" class="form-control" name="quantia" id="quantia" value="{{ old('quantia', $order->quantia ?? '') }}" required>
</div>

<div class="form-group">
    <label for="preco">Preço</label>
    <input type="text" class="form-control" name="preco" id="preco" value="{{ old('preco', $order->preco ?? '') }}" required>
</div>

<div class="form-group">
    <label for="local">Local</label>
    <input type="text" class="form-control" name="local" id="local" value="{{ old('local', $order->local ?? '') }}" required>
</div>

<div class="form-group">
    <label for="descricao">Descrição</label>
    <textarea class="form-control" name="descricao" id="descricao">{{ old('descricao', $order->descricao ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="fornecedor">Fornecedor</label>
    <textarea class="form-control" name="fornecedor" id="fornecedor">{{ old('fornecedor', $order->fornecedor ?? '') }}</textarea>
</div>
