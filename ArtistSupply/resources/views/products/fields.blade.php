<div class="form-group">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" name="nome" id="nome" value="{{ old('nome', $product->nome ?? '') }}" required>
</div>

<div class="form-group">
    <label for="quantia">Quantidade</label>
    <input type="number" class="form-control" name="quantia" id="quantia" value="{{ old('quantia', $product->quantia ?? '') }}" required>
</div>

<div class="form-group">
    <label for="preco">Preço</label>
    <input type="text" class="form-control" name="preco" id="preco" value="{{ old('preco', $product->preco ?? '') }}" required>
</div>

<div class="form-group">
    <label for="local">Local</label>
    <input type="text" class="form-control" name="local" id="local" value="{{ old('local', $product->local ?? '') }}" required>
</div>

<div class="form-group">
    <label for="descricao">Descrição</label>
    <textarea class="form-control" name="descricao" id="descricao">{{ old('descricao', $product->descricao ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="extra">Informações Extras</label>
    <input type="text" class="form-control" name="extra" id="extra" value="{{ old('extra', $product->extra ?? '') }}">
</div>

<div class="form-group">
    <label for="category_id">Categoria</label>
    <select class="form-control" name="category_id" id="category_id" required>
        <option value="">Selecione uma categoria</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                {{ $category->nome }}
            </option>
        @endforeach
    </select>
</div>

<script>
    function formatCurrency(value) {
        value = value.replace(/\D/g, '');
        
        return value.replace(/(\d)(\d{2})$/, "$1,$2")
                    .replace(/(?=(\d{3})+(\D))/g, "$&.");
    }

    document.addEventListener('DOMContentLoaded', function() {
        const priceInput = document.getElementById('preco');

        priceInput.addEventListener('input', function() {
            this.value = formatCurrency(this.value);
        });
    });
</script>
