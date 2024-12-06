import React, { useEffect, useState } from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet, Alert } from 'react-native';
import { Picker } from '@react-native-picker/picker';
import { useForm, Controller, SubmitHandler } from 'react-hook-form';
import axios from 'axios';
import { useRouter } from 'expo-router';

// Tipando a resposta de categoria
interface Category {
  id: number;
  nome: string;
}

interface FormData {
  nome: string;
  quantia: number;
  preco: string;
  local: string;
  descricao: string;
  extra: string;
  category_id: number;
}

export default function ProductRegisterScreen() {
  const { control, handleSubmit, reset } = useForm<FormData>({
    defaultValues: {
      nome: '',
      quantia: 0,
      preco: '',
      local: '',
      descricao: '',
      extra: '',
      category_id: 0,
    },
  });
  const [categories, setCategories] = useState<Category[]>([]);
  const [loading, setLoading] = useState<boolean>(false);
  const router = useRouter();

  useEffect(() => {
    // Buscar categorias com a tipagem definida
    const fetchCategories = async () => {
      try {
        const response = await axios.get<{ categories: Category[] }>(
          'http://localhost:8000/api/api/estoque/create'
        );
        setCategories(response.data.categories);
      } catch (error) {
        Alert.alert('Erro ao carregar as categorias');
      }
    };

    fetchCategories();
  }, []);

  const onSubmit: SubmitHandler<FormData> = async (data) => {
    try {
      data.quantia = Number(data.quantia); // Garantir que quantia é um número

      const response = await axios.post('http://localhost:8000/api/api/estoque/store', data);
      if (response.status === 201) {
        Alert.alert('Sucesso', 'Produto criado com sucesso!', [
          { text: 'OK', onPress: () => router.push('/productList') },
        ]);
        reset();
      }
    } catch (error) {
      Alert.alert('Ocorreu um erro ao cadastrar. Tente novamente.');
    }
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Cadastrar Produto</Text>

      <Controller
        control={control}
        name="nome"
        rules={{ required: 'Nome é obrigatório' }}
        render={({ field: { onChange, value } }) => (
          <TextInput
            style={styles.input}
            placeholder="Nome"
            placeholderTextColor="#aaa"
            value={value || ''} // Garantir que o valor não seja undefined
            onChangeText={onChange}
          />
        )}
      />

      <Controller
        control={control}
        name="quantia"
        rules={{
          required: 'Quantia é obrigatória',
          pattern: {
            value: /^[0-9]+$/,
            message: 'Quantia deve ser um número inteiro',
          },
        }}
        render={({ field: { onChange, value } }) => (
          <TextInput
            style={styles.input}
            placeholder="Quantia"
            placeholderTextColor="#aaa"
            keyboardType="numeric"
            value={value ? String(value) : ''} // Garantir que o valor seja uma string ou vazio
            onChangeText={(text) => onChange(text ? Number(text) : 0)} // Converte texto para número
          />
        )}
      />

      <Controller
        control={control}
        name="preco"
        rules={{ required: 'Preço é obrigatório' }}
        render={({ field: { onChange, value } }) => (
          <TextInput
            style={styles.input}
            placeholder="Preço"
            placeholderTextColor="#aaa"
            value={value || ''} // Garantir que o valor não seja undefined
            onChangeText={onChange}
          />
        )}
      />

      <Controller
        control={control}
        name="local"
        rules={{ required: 'Local é obrigatório' }}
        render={({ field: { onChange, value } }) => (
          <TextInput
            style={styles.input}
            placeholder="Local"
            placeholderTextColor="#aaa"
            value={value || ''} // Garantir que o valor não seja undefined
            onChangeText={onChange}
          />
        )}
      />

      <Controller
        control={control}
        name="descricao"
        render={({ field: { onChange, value } }) => (
          <TextInput
            style={styles.input}
            placeholder="Descrição"
            placeholderTextColor="#aaa"
            value={value || ''} // Garantir que o valor não seja undefined
            onChangeText={onChange}
          />
        )}
      />

      <Controller
        control={control}
        name="extra"
        render={({ field: { onChange, value } }) => (
          <TextInput
            style={styles.input}
            placeholder="Informações Extras"
            placeholderTextColor="#aaa"
            value={value || ''} // Garantir que o valor não seja undefined
            onChangeText={onChange}
          />
        )}
      />

      <Controller
        control={control}
        name="category_id"
        rules={{ required: 'Categoria é obrigatória' }}
        render={({ field: { onChange, value } }) => (
          <View style={styles.input}>
            <Picker
              selectedValue={value || 0} // Garantir que o valor não seja undefined
              onValueChange={onChange}
              style={{ height: 50, color: '#fff', backgroundColor: '#1c0736' }}
            >
              <Picker.Item label="Selecione a categoria" value={0} />
              {categories.map((category) => (
                <Picker.Item key={category.id} label={category.nome} value={category.id} />
              ))}
            </Picker>
          </View>
        )}
      />

      <TouchableOpacity style={styles.button} onPress={handleSubmit(onSubmit)}>
        <Text style={styles.buttonText}>Cadastrar Produto</Text>
      </TouchableOpacity>

      <TouchableOpacity onPress={() => router.push('/productList')}>
        <Text style={styles.link}>Voltar para a lista de produtos</Text>
      </TouchableOpacity>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#121120',
    padding: 20,
    justifyContent: 'center',
  },
  title: {
    fontSize: 28,
    fontWeight: 'bold',
    color: '#fff',
    textAlign: 'center',
    marginBottom: 20,
  },
  input: {
    backgroundColor: '#1c0736',
    color: '#fff',
    padding: 10,
    marginBottom: 15,
    borderRadius: 5,
    borderWidth: 1,
    borderColor: '#6c26bb',
  },
  button: {
    backgroundColor: '#6c26bb',
    padding: 15,
    borderRadius: 5,
    alignItems: 'center',
  },
  buttonText: {
    color: '#fff',
    fontWeight: 'bold',
  },
  link: {
    color: '#9d48ec',
    textAlign: 'center',
    marginTop: 15,
  },
});
