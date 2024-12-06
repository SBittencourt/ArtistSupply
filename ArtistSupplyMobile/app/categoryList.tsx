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

interface Category {
  id: number;
  nome: string;
  descricao: string;
  extra: string;
}

const CategoryList: React.FC = () => {
  const [categories, setCategories] = useState<Category[]>([]);
  const [search, setSearch] = useState('');

  useEffect(() => {
    fetchCategories();
  }, [search]);

  const fetchCategories = async () => {
    try {
      const response = await axios.get<Category[]>('http://localhost:8000/api/api/categorias', {
        params: { search },
      });
      setCategories(response.data);
    } catch (error) {
      console.error('Erro ao buscar categorias:', error);
    }
  };

  const handleDelete = async (id: number) => {
    try {
      await axios.delete(`http://localhost:8000/api/api/categorias/${id}`);
      fetchCategories();
    } catch (error) {
      console.error('Erro ao excluir categoria:', error);
    }
  };

  const handleSearch = () => {
    fetchCategories();
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
          <Text style={styles.title}>Lista de Categorias</Text>
          <Link href="/categoryCreate" style={styles.createButton}>
            <Button title="Criar Nova Categoria" color="#6c26bb" />
          </Link>
        </View>

        <View style={styles.filterContainer}>
          <TextInput
            style={styles.searchInput}
            placeholder="Pesquisar categorias..."
            placeholderTextColor="#aaa"
            value={search}
            onChangeText={setSearch}
          />
          <Button title="Pesquisar" onPress={handleSearch} color="#1c0736" />
        </View>

        <FlatList
          data={categories}
          keyExtractor={(item) => item.id.toString()}
          renderItem={({ item }: { item: Category }) => (
            <View style={styles.categoryItem}>
              <Text style={styles.categoryName}>{item.nome}</Text>
              <Text style={styles.category}>Descrição: {item.descricao || 'N/A'}</Text>
              <Text style={styles.category}>Extras: {item.extra || 'N/A'}</Text>
              <View style={styles.actions}>
                <Link
                  href={{
                    pathname: '/categoryEdit/[categoryId]',
                    params: { categoryId: item.id },
                  }}
                  style={styles.editButton}
                >
                  <Icon name="edit" type="font-awesome" color="#fff" />
                </Link>
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
  categoryItem: {
    padding: 15,
    backgroundColor: '#1c0736',
    marginBottom: 10,
    borderRadius: 8,
    marginHorizontal: 20,
  },
  categoryName: {
    fontSize: 20,
    fontWeight: 'bold',
    color: '#fff',
    marginBottom: 8,
  },
  category: {
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
  deleteButton: {
    backgroundColor: '#c21807',
    padding: 8,
    borderRadius: 8,
  },
});

export default CategoryList;
