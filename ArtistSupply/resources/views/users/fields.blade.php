<div class="row">
    <div class="form-group col-md-6">
        <label> Nome: <span class="text-danger">*</span>:</label>
        <input type="text" class="form-control" value="{{ $user->name ?? '' }}" name="name" id="name" required>
    </div>

    <div class="form-group col-md-6">
        <label> Email: </label>
        <input type="email" class="form-control" value="{{ $user->email ?? '' }}" name="email" id="email" required>
    </div>

    <div class="form-group col-md-6">
        <label> Senha: </label>
        <input type="password" class="form-control" name="password" id="password">
        <small class="form-text text-muted">
            Deixe em branco se não desejar alterar a senha.
        </small>
    </div>
    

    <div class="form-group col-md-6">
        <label> Telefone: </label>
        <input type="text" class="form-control" value="{{ $user->phone ?? '' }}" name="phone" id="phone" maxlength="15" required>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const phoneInput = document.getElementById('phone');

        phoneInput.addEventListener('input', function (event) {
            let input = phoneInput.value.replace(/\D/g, ''); 

            if (input.length > 11) {
                input = input.slice(0, 11); 
            }

            if (input.length > 2) {
                input = `(${input.slice(0, 2)}) ${input.slice(2)}`;
            }
            if (input.length > 9) {
                input = `${input.slice(0, 9)}-${input.slice(9)}`;
            }

            phoneInput.value = input;
        });
    });
</script>
