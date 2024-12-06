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
import { Link } from 'expo-router'; // Usando o Link do expo-router
import { Icon } from 'react-native-elements';

interface Category {
  id: number;
  nome: string;
}

interface Product {
  id: number;
  nome: string;
  quantia: number;
  preco: string;
  local: string;
  descricao?: string;
  extra?: string;
  category_id: number;
  user_id: number;
}

const ProductList: React.FC = () => {
  const [products, setProducts] = useState<Product[]>([]);
  const [search, setSearch] = useState('');
  const [category, setCategory] = useState('');
  const [categories, setCategories] = useState<Category[]>([]);

  useEffect(() => {
    fetchProducts();
  }, [search, category]);

  const fetchProducts = async () => {
    try {
      const response = await axios.get<{ products: Product[] }>(
        'http://localhost:8000/api/api/estoque',
        {
          params: { search, category },
        }
      );
      setProducts(response.data.products);
    } catch (error) {
      console.error('Erro ao buscar produtos:', error);
    }
  };

  const handleDelete = async (id: number) => {
    try {
      await axios.delete(`http://localhost:8000/api/api/estoque/destroy/${id}`);
      fetchProducts();
    } catch (error) {
      console.error('Erro ao excluir produto:', error);
    }
  };

  const handleSearch = () => {
    fetchProducts();
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
          <Text style={styles.title}>Lista de Produtos</Text>
          <Link href="/productCreate" style={styles.createButton}>
            <Button title="Criar Novo Produto" color="#6c26bb" />
          </Link>
        </View>

        <View style={styles.filterContainer}>
          <TextInput
            style={styles.searchInput}
            placeholder="Pesquisar produtos..."
            placeholderTextColor="#aaa"
            value={search}
            onChangeText={setSearch}
          />
          <Button title="Pesquisar" onPress={handleSearch} color="#1c0736" />
        </View>

        {/* Lista de produtos */}
        <FlatList
          data={products}
          keyExtractor={(item) => item.id.toString()}
          renderItem={({ item }: { item: Product }) => (
            <View style={styles.productItem}>
              <Text style={styles.productName}>{item.nome}</Text>
              <Text style={styles.product}>{item.quantia} em estoque</Text>
              <Text style={styles.product}>{item.preco}</Text>
              <Text style={styles.product}>{item.local}</Text>
              <View style={styles.actions}>
                <Link href={`/`} style={styles.editButton}>
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
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.3,
    shadowRadius: 8,
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
  productItem: {
    padding: 15,
    backgroundColor: '#1c0736',
    marginBottom: 10,
    borderRadius: 8,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.3,
    shadowRadius: 6,
    marginHorizontal: 20,
  },
  productName: {
    fontSize: 20,
    fontWeight: 'bold',
    color: '#fff',
    marginBottom: 8,
  },
  product: {
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
    justifyContent: 'center',
    alignItems: 'center',
  },
  deleteButton: {
    backgroundColor: '#c21807',
    padding: 8,
    borderRadius: 8,
    justifyContent: 'center',
    alignItems: 'center',
  },
});

export default ProductList;
