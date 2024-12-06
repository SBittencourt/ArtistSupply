import React, { useEffect, useState } from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet, Alert} from 'react-native'; // Adicionando Picker para seleção de categoria
import { Picker } from '@react-native-picker/picker';
import { useRouter, useLocalSearchParams } from 'expo-router';
import axios from 'axios';

interface Product {
  id: number;
  nome: string;
  quantia: number;
  preco: string;
  local: string;
  descricao: string;
  extra: string;
  category_id: number;
}

interface Category {
  id: number;
  name: string;
}

export default function EditProductScreen() {
  const router = useRouter();
  const { productId } = useLocalSearchParams(); // Pega o ID da URL
  console.log({productId});

  const [product, setProduct] = useState<Product | null>(null);
  const [categories, setCategories] = useState<Category[]>([]); // Adicionando categorias
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    if (productId) {
      const fetchProduct = async () => {
        setLoading(true);
        try {
          const response = await axios.get(`http://localhost:8000/api/api/estoque/${productId}`);
          setProduct(response.data.product); // Produto retornado
          setCategories(response.data.categories); // Categorias retornadas
        } catch (error) {
          Alert.alert('Erro ao carregar os dados do produto');
        } finally {
          setLoading(false);
        }
      };

      fetchProduct();
    }
  }, [productId]);

  const handleEdit = async () => {
    if (product && productId) {
      try {
        await axios.put(`http://localhost:8000/api/api/estoque/update/${productId}`, product);
        Alert.alert('Sucesso', 'Produto atualizado com sucesso!', [
          { text: 'OK', onPress: () => router.push('/productList') },
        ]);
      } catch (error) {
        Alert.alert('Erro ao atualizar o produto');
      }
    }
  };

  if (loading) return <Text>Carregando...</Text>;

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Editar Produto</Text>
      <TextInput
        style={styles.input}
        value={product?.nome || ''}
        onChangeText={(text) => setProduct({ ...product!, nome: text })}
        placeholder="Nome"
      />
      <TextInput
        style={styles.input}
        value={product?.quantia.toString() || ''}
        keyboardType="numeric"
        onChangeText={(text) => setProduct({ ...product!, quantia: Number(text) })}
        placeholder="Quantia"
      />
      <TextInput
        style={styles.input}
        value={product?.preco || ''}
        onChangeText={(text) => setProduct({ ...product!, preco: text })}
        placeholder="Preço"
      />
      <TextInput
        style={styles.input}
        value={product?.local || ''}
        onChangeText={(text) => setProduct({ ...product!, local: text })}
        placeholder="Local"
      />
      <TextInput
        style={styles.input}
        value={product?.descricao || ''}
        onChangeText={(text) => setProduct({ ...product!, descricao: text })}
        placeholder="Descrição"
      />
      <TextInput
        style={styles.input}
        value={product?.extra || ''}
        onChangeText={(text) => setProduct({ ...product!, extra: text })}
        placeholder="Informações Extras"
      />
      <Picker
        selectedValue={product?.category_id}
        onValueChange={(itemValue: any) => setProduct({ ...product!, category_id: Number(itemValue) })}
        style={styles.input}
      >
        {categories.map((category) => (
          <Picker.Item key={category.id} label={category.name} value={category.id} />
        ))}
      </Picker>
      <TouchableOpacity style={styles.button} onPress={handleEdit}>
        <Text style={styles.buttonText}>Salvar Alterações</Text>
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
