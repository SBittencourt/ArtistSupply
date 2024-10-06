<div class="form-group">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" name="nome" id="nome" value="{{ old('nome', $event->nome ?? '') }}" required>
</div>

<div class="form-group">
    <label for="data_inicio">Data de Início</label>
    <input type="date" class="form-control" name="data_inicio" id="data_inicio" value="{{ old('data_inicio', $event->data_inicio ?? '') }}" required>
</div>

<div class="form-group">
    <label for="data_fim">Data de Fim</label>
    <input type="date" class="form-control" name="data_fim" id="data_fim" value="{{ old('data_fim', $event->data_fim ?? '') }}">
</div>

<div class="form-group">
    <label for="local">Local</label>
    <input type="text" class="form-control" name="local" id="local" value="{{ old('local', $event->local ?? '') }}" required>
</div>

<div class="form-group">
    <label for="descricao">Descrição</label>
    <textarea class="form-control" name="descricao" id="descricao">{{ old('descricao', $event->descricao ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="extra">Informações Extras</label>
    <input type="text" class="form-control" name="extra" id="extra" value="{{ old('extra', $event->extra ?? '') }}">
</div>
