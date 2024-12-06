import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  TextInput,
  Button,
  FlatList,
  TouchableOpacity,
  StyleSheet,
  ScrollView,
} from 'react-native';
import axios from 'axios';
import { Link } from 'expo-router';
import { Icon } from 'react-native-elements';

interface Event {
  id: number;
  nome: string;
  data_inicio: string;
  data_fim: string;
  activeEvent?: { id: number; end_time: string | null };
}

const EventList: React.FC = () => {
  const [events, setEvents] = useState<Event[]>([]);
  const [search, setSearch] = useState('');

  useEffect(() => {
    fetchEvents();
  }, [search]);

  const fetchEvents = async () => {
    try {
      const response = await axios.get<Event[]>(
        'http://localhost:8000/api/api/eventos',
        {
          params: { search },
        }
      );
      setEvents(response.data); // Atualize diretamente com os dados da API
    } catch (error) {
      console.error('Erro ao buscar eventos:', error);
    }
  };

  const handleDelete = async (id: number) => {
    try {
      await axios.delete(`http://localhost:8000/api/api/eventos/destroy/${id}`);
      fetchEvents();
    } catch (error) {
      console.error('Erro ao excluir evento:', error);
    }
  };

  const handleSearch = () => {
    fetchEvents();
  };

  return (
    <View style={styles.container}>
      <View style={styles.menuContainer}>
        <Link href="/home" style={styles.backButton}>
          <Icon name="arrow-left" type="font-awesome" color="#fff" size={24} />
        </Link>
      </View>

      <ScrollView style={styles.scrollView}>
        <View style={styles.header}>
          <Text style={styles.title}>Lista de Eventos</Text>
          <Link href="/eventCreate" style={styles.createButton}>
            <Button title="Criar Novo Evento" color="#6c26bb" />
          </Link>
        </View>

        <View style={styles.filterContainer}>
          <TextInput
            style={styles.searchInput}
            placeholder="Pesquisar eventos..."
            placeholderTextColor="#aaa"
            value={search}
            onChangeText={setSearch}
          />
          <Button title="Pesquisar" onPress={handleSearch} color="#1c0736" />
        </View>

        <FlatList
          data={events}
          keyExtractor={(item) => item.id.toString()}
          renderItem={({ item }: { item: Event }) => (
            <View style={styles.eventItem}>
              <Text style={styles.eventName}>{item.nome}</Text>
              <Text style={styles.event}>
                Início: {new Date(item.data_inicio).toLocaleDateString()}
              </Text>
              <Text style={styles.event}>
                Fim: {new Date(item.data_fim).toLocaleDateString()}
              </Text>
              <View style={styles.actions}>
                <Link
                  href={{
                    pathname: '/eventEdit/[eventId]',
                    params: { eventId: item.id },
                  }}
                  style={styles.editButton}
                >
                  <Icon name="edit" type="font-awesome" color="#fff" />
                </Link>
                {item.activeEvent ? (
                  <TouchableOpacity
                    style={styles.viewButton}
                    onPress={() =>
                      console.log('Visualizar evento ativo ou resumo:', item.activeEvent)
                    }
                  >
                    <Icon name="eye" type="font-awesome" color="#fff" />
                  </TouchableOpacity>
                ) : (
                  <TouchableOpacity
                    style={styles.startButton}
                    onPress={() => console.log('Iniciar evento:', item.id)}
                  >
                    <Icon name="play" type="font-awesome" color="#fff" />
                  </TouchableOpacity>
                )}
                <TouchableOpacity
                  onPress={() => handleDelete(item.id)}
                  style={styles.deleteButton}
                >
                  <Icon name="trash" type="font-awesome" color="#fff" />
                </TouchableOpacity>
              </View>
            </View>
          )}
        />
      </ScrollView>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#121120',
  },
  menuContainer: {
    position: 'absolute',
    top: 20,
    left: 20,
    zIndex: 10,
  },
  backButton: {
    padding: 10,
    backgroundColor: '#6c26bb',
    borderRadius: 50,
    alignItems: 'center',
    justifyContent: 'center',
  },
  scrollView: {
    marginTop: 80,
  },
  header: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 20,
    paddingHorizontal: 20,
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#fff',
  },
  createButton: {
    backgroundColor: '#6c26bb',
    borderRadius: 8,
    paddingVertical: 8,
    paddingHorizontal: 16,
  },
  filterContainer: {
    marginBottom: 20,
    paddingHorizontal: 20,
  },
  searchInput: {
    borderWidth: 1,
    borderColor: '#6c26bb',
    padding: 10,
    color: '#fff',
    borderRadius: 8,
    backgroundColor: '#1c0736',
    marginBottom: 10,
  },
  eventItem: {
    padding: 15,
    backgroundColor: '#1c0736',
    marginBottom: 10,
    borderRadius: 8,
    marginHorizontal: 20,
  },
  eventName: {
    fontSize: 20,
    fontWeight: 'bold',
    color: '#fff',
    marginBottom: 8,
  },
  event: {
    fontSize: 14,
    color: '#fff',
    marginBottom: 8,
  },
  actions: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginTop: 10,
  },
  editButton: {
    backgroundColor: '#1c0736',
    padding: 8,
    borderRadius: 8,
  },
  viewButton: {
    backgroundColor: '#007bff',
    padding: 8,
    borderRadius: 8,
  },
  startButton: {
    backgroundColor: '#28a745',
    padding: 8,
    borderRadius: 8,
  },
  deleteButton: {
    backgroundColor: '#c21807',
    padding: 8,
    borderRadius: 8,
  },
});

export default EventList;
