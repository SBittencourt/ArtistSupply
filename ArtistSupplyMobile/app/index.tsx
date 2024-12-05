import React, { useState } from 'react';
import {
  View,
  Text,
  TextInput,
  TouchableOpacity,
  StyleSheet,
  Alert,
} from 'react-native';
import axios from 'axios';
import { useRouter } from 'expo-router';

export default function LoginScreen() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [loading, setLoading] = useState(false);

  const router = useRouter(); // Hook para navegação

  const handleLogin = async () => {
    if (!email || !password) {
      Alert.alert('Erro', 'Por favor, preencha todos os campos.');
      return;
    }

    setLoading(true);
    try {
      const response = await axios.post('http://localhost:8000/api/api/auth/login', {
        email,
        password,
      });
      console.log('Login bem-sucedido:', response.data);
      Alert.alert('Sucesso', 'Login realizado com sucesso!');
      
      router.push('/home');
    } catch (error) {
      console.error('Erro no login:', error);
      Alert.alert('Erro', 'Credenciais inválidas. Tente novamente.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Artist Supply</Text>
      <View style={styles.formContainer}>
        <Text style={styles.label}>Email</Text>
        <TextInput
          style={styles.input}
          placeholder="Digite seu email"
          placeholderTextColor="#aaa"
          keyboardType="email-address"
          value={email}
          onChangeText={setEmail}
        />
        <Text style={styles.label}>Senha</Text>
        <TextInput
          style={styles.input}
          placeholder="Digite sua senha"
          placeholderTextColor="#aaa"
          secureTextEntry
          value={password}
          onChangeText={setPassword}
        />
        <TouchableOpacity
          style={[styles.button, loading && styles.buttonDisabled]}
          onPress={handleLogin}
          disabled={loading}
        >
          <Text style={styles.buttonText}>{loading ? 'Carregando...' : 'Entrar'}</Text>
        </TouchableOpacity>
        <TouchableOpacity onPress={() => router.push('/register')}>
            <Text style={styles.linkText}>Não possui uma conta? Criar uma conta</Text>
        </TouchableOpacity>

      </View>
    </View>
  );
}

const styles = StyleSheet.create({
    container: {
      flex: 1,
      backgroundColor: '#121120', // Cor de fundo ajustada para a mesma da tela de registro
      alignItems: 'center', // Adicionando alinhamento centralizado no eixo horizontal
      justifyContent: 'center', // Centralizando o conteúdo verticalmente
      padding: 20,
    },
    title: {
      fontSize: 28, // Tamanho de fonte igual ao da tela de registro
      fontWeight: 'bold',
      color: '#fff',
      marginBottom: 20,
    },
    formContainer: {
      width: '100%',
      padding: 20,
      backgroundColor: 'rgba(28, 7, 54, 0.9)', // Mantendo o fundo escuro, mas com opacidade
      borderRadius: 10,
      shadowColor: '#000',
      shadowOffset: { width: 0, height: 4 },
      shadowOpacity: 0.3,
      shadowRadius: 10,
    },
    label: {
      fontSize: 16,
      color: '#fff',
      marginBottom: 5,
    },
    input: {
      backgroundColor: '#1c0736', // Cor do campo de input ajustada
      color: '#fff',
      padding: 10,
      borderRadius: 5,
      marginBottom: 15,
      borderWidth: 1, // Adicionando borda para combinar com o estilo da tela de registro
      borderColor: '#6c26bb', // Cor da borda igual à da tela de registro
    },
    button: {
      backgroundColor: '#6c26bb', // Cor do botão ajustada
      padding: 15,
      borderRadius: 5,
      alignItems: 'center',
    },
    buttonDisabled: {
      backgroundColor: '#453073', // Cor quando o botão estiver desabilitado
    },
    buttonText: {
      color: '#fff',
      fontSize: 16,
      fontWeight: 'bold',
    },
    linkText: {
      color: '#9d48ec', // Cor do link ajustada para ficar consistente com o estilo da tela de registro
      textAlign: 'center',
      marginTop: 15,
    },
  });
  