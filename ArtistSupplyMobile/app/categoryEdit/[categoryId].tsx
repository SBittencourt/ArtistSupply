import React, { useEffect, useState } from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet, Alert } from 'react-native';
import { useForm, Controller, SubmitHandler } from 'react-hook-form';
import axios from 'axios';
import { useRouter, useLocalSearchParams } from 'expo-router';

interface FormData {
  nome: string;
  descricao: string;
  extra: string;
}

export default function CategoryEditScreen() {
  const { control, handleSubmit, setValue } = useForm<FormData>({
    defaultValues: {
      nome: '',
      descricao: '',
      extra: '',
    },
  });

  const router = useRouter();
  const { categoryId } = useLocalSearchParams(); // Pega o ID da categoria na URL

  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    if (categoryId) {
      const fetchCategory = async () => {
        setLoading(true);
        try {
          const response = await axios.get(`http://localhost:8000/api/api/categorias/show/${categoryId}`);
          const category = response.data; // Assumindo que a resposta contém diretamente os dados da categoria

          // Preenche o formulário com os dados da categoria
          setValue('nome', category.nome);
          setValue('descricao', category.descricao);
          setValue('extra', category.extra);
        } catch (error) {
          Alert.alert('Erro ao carregar os dados da categoria');
        } finally {
          setLoading(false);
        }
      };

      fetchCategory();
    }
  }, [categoryId, setValue]);

  const onSubmit: SubmitHandler<FormData> = async (data) => {
    try {
      const response = await axios.put(`http://localhost:8000/api/api/categorias/${categoryId}`, data);
      if (response.status === 200) {
        Alert.alert('Sucesso', 'Categoria atualizada com sucesso!', [
          { text: 'OK', onPress: () => router.push('/categoryList') },
        ]);
      }
    } catch (error) {
      Alert.alert('Erro', 'Ocorreu um erro ao atualizar a categoria. Tente novamente.');
    }
  };

  if (loading) return <Text>Carregando...</Text>;

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Editar Categoria</Text>

      <Controller
        control={control}
        name="nome"
        rules={{ required: 'Nome é obrigatório' }}
        render={({ field: { onChange, value } }) => (
          <TextInput
            style={styles.input}
            placeholder="Nome"
            placeholderTextColor="#aaa"
            value={value}
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
            value={value}
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
            value={value}
            onChangeText={onChange}
          />
        )}
      />

      <TouchableOpacity style={styles.button} onPress={handleSubmit(onSubmit)}>
        <Text style={styles.buttonText}>Salvar Alterações</Text>
      </TouchableOpacity>

      <TouchableOpacity onPress={() => router.push('/categoryList')}>
        <Text style={styles.link}>Voltar para a lista de categorias</Text>
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
    padding: 15,
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
