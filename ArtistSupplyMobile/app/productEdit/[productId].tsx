import React, { useEffect, useState } from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet, Alert } from 'react-native';
import { useRouter, useLocalSearchParams } from 'expo-router'; // Importando useRouter e useLocalSearchParams
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

export default function EditProductScreen() {
  const router = useRouter();
  const { id } = useLocalSearchParams(); 

  const [product, setProduct] = useState<Product | null>(null);
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    if (id) {
      const fetchProduct = async () => {
        setLoading(true);
        try {
          const response = await axios.get<Product>(`http://localhost:8000/api/api/estoque/${id}`);
          setProduct(response.data);
        } catch (error) {
          Alert.alert('Erro ao carregar os dados do produto');
        } finally {
          setLoading(false);
        }
      };

      fetchProduct();
    }
  }, [id]);

  const handleEdit = async () => {
    if (product && id) {
      try {
        const updatedProduct = {
          ...product,
          id: Number(id), 
        };

        await axios.put(`http://localhost:8000/api/api/estoque/update/${id}`, updatedProduct);
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
      <TouchableOpacity style={styles.button} onPress={handleEdit}>
        <Text style={styles.buttonText}>Salvar Alterações</Text>
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
});
