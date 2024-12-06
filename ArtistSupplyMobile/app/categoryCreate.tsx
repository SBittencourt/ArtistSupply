import React from 'react';
import { useState } from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet, Alert } from 'react-native';
import { useForm, Controller, SubmitHandler } from 'react-hook-form';
import axios from 'axios';
import { useRouter } from 'expo-router';

interface FormData {
  nome: string;
  descricao: string;
  extra: string;
}

export default function CategoryRegisterScreen() {
  const { control, handleSubmit, reset } = useForm<FormData>({
    defaultValues: {
      nome: '',
      descricao: '',
      extra: '',
    },
  });

  const router = useRouter();

  const onSubmit: SubmitHandler<FormData> = async (data) => {
    try {
      const response = await axios.post('http://localhost:8000/api/api/categorias/store', data);
      if (response.status === 201) {
        Alert.alert('Sucesso', 'Categoria criada com sucesso!', [
          { text: 'OK', onPress: () => router.push('/categoryList') },
        ]);
        reset();
      }
    } catch (error) {
      Alert.alert('Erro', 'Ocorreu um erro ao cadastrar a categoria. Tente novamente.');
    }
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Cadastrar Categoria</Text>

      <Controller
        control={control}
        name="nome"
        rules={{ required: 'O nome é obrigatório' }}
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
        <Text style={styles.buttonText}>Cadastrar Categoria</Text>
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
