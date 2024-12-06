import React, { useEffect, useState } from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet, Alert } from 'react-native';
import { useForm, Controller, SubmitHandler } from 'react-hook-form';
import DateTimePicker from '@react-native-community/datetimepicker';
import axios from 'axios';
import { useRouter, useLocalSearchParams } from 'expo-router';

interface FormData {
  nome: string;
  data_inicio: string;
  data_fim: string;
  local: string;
  descricao: string;
  extra: string;
}

export default function EditEventScreen() {
  const { control, handleSubmit, setValue } = useForm<FormData>({
    defaultValues: {
      nome: '',
      data_inicio: '',
      data_fim: '',
      local: '',
      descricao: '',
      extra: '',
    },
  });

  const router = useRouter();
  const { eventId } = useLocalSearchParams(); // Pega o ID do evento na URL

  const [startDate, setStartDate] = useState<Date | undefined>(undefined);
  const [endDate, setEndDate] = useState<Date | undefined>(undefined);
  const [showStartPicker, setShowStartPicker] = useState(false);
  const [showEndPicker, setShowEndPicker] = useState(false);
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    if (eventId) {
      const fetchEvent = async () => {
        setLoading(true);
        try {
          const response = await axios.get(`http://localhost:8000/api/api/eventos/show/${eventId}`);
          
          // A resposta vem diretamente como o objeto do evento
          const event = response.data; // Use a resposta diretamente, pois não há a chave 'event'

          setStartDate(new Date(event.data_inicio)); // Define a data de início
          setEndDate(new Date(event.data_fim)); // Define a data de fim

          // Preenche o formulário com os dados do evento
          setValue('nome', event.nome);
          setValue('data_inicio', event.data_inicio);
          setValue('data_fim', event.data_fim);
          setValue('local', event.local);
          setValue('descricao', event.descricao);
          setValue('extra', event.extra);
        } catch (error) {
          Alert.alert('Erro ao carregar os dados do evento');
        } finally {
          setLoading(false);
        }
      };

      fetchEvent();
    }
  }, [eventId, setValue]);

  const handleStartDateChange = (event: any, selectedDate?: Date) => {
    setShowStartPicker(false);
    if (selectedDate) {
      setStartDate(selectedDate);
      setValue('data_inicio', selectedDate.toISOString().split('T')[0]); // Usando setValue corretamente
    }
  };

  const handleEndDateChange = (event: any, selectedDate?: Date) => {
    setShowEndPicker(false);
    if (selectedDate) {
      setEndDate(selectedDate);
      setValue('data_fim', selectedDate.toISOString().split('T')[0]); // Usando setValue corretamente
    }
  };

  const onSubmit: SubmitHandler<FormData> = async (data) => {
    try {
      const response = await axios.put(`http://localhost:8000/api/api/eventos/${eventId}`, data);
      if (response.status === 200) {
        Alert.alert('Sucesso', 'Evento atualizado com sucesso!', [
          { text: 'OK', onPress: () => router.push('/eventList') },
        ]);
      }
    } catch (error) {
      Alert.alert('Erro', 'Ocorreu um erro ao atualizar o evento. Tente novamente.');
    }
  };

  if (loading) return <Text>Carregando...</Text>;

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Editar Evento</Text>

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

      <TouchableOpacity
        style={styles.input}
        onPress={() => setShowStartPicker(true)}
      >
        <Text style={styles.placeholder}>
          {startDate ? startDate.toISOString().split('T')[0] : 'Selecione a Data de Início'}
        </Text>
      </TouchableOpacity>
      {showStartPicker && (
        <DateTimePicker
          value={startDate || new Date()}
          mode="date"
          display="default"
          onChange={handleStartDateChange}
        />
      )}

      <TouchableOpacity
        style={styles.input}
        onPress={() => setShowEndPicker(true)}
      >
        <Text style={styles.placeholder}>
          {endDate ? endDate.toISOString().split('T')[0] : 'Selecione a Data de Fim'}
        </Text>
      </TouchableOpacity>
      {showEndPicker && (
        <DateTimePicker
          value={endDate || new Date()}
          mode="date"
          display="default"
          onChange={handleEndDateChange}
        />
      )}

      <Controller
        control={control}
        name="local"
        rules={{ required: 'Local é obrigatório' }}
        render={({ field: { onChange, value } }) => (
          <TextInput
            style={styles.input}
            placeholder="Local"
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

      <TouchableOpacity onPress={() => router.push('/eventList')}>
        <Text style={styles.link}>Voltar para a lista de eventos</Text>
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
  placeholder: {
    color: '#aaa',
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
