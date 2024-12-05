import React from 'react';
import { View, Text, StyleSheet } from 'react-native';
import { Link } from 'expo-router';
import { Ionicons } from '@expo/vector-icons';

const Home: React.FC = () => {
  return (
    <View style={styles.container}>
      <Text style={styles.welcomeText}>Bem-vindo ao Artist Supply!</Text>

      <View style={styles.linksContainer}>
        <View style={styles.linkRow}>
          <Link href="/" style={styles.linkButton}>
            <Ionicons name="calendar-outline" size={24} color="#fff" style={styles.icon} />
            <Text style={styles.linkText}>Eventos</Text>
          </Link>
          <Link href="/" style={styles.linkButton}>
            <Ionicons name="list-outline" size={24} color="#fff" style={styles.icon} />
            <Text style={styles.linkText}>Categorias</Text>
          </Link>
        </View>

        <View style={styles.linkRow}>
          <Link href="/" style={styles.linkButton}>
            <Ionicons name="cube-outline" size={24} color="#fff" style={styles.icon} />
            <Text style={styles.linkText}>Estoque</Text>
          </Link>
          <Link
            href="https://docs.google.com/spreadsheets/u/0/d/1m0L1dx60k05oz-6jqm8h9NDiqRTBc9gOe5X14t2aYw0/htmlview"
            style={[styles.linkButton]}
          >
            <Ionicons name="people-outline" size={24} color="#fff" style={styles.icon} />
            <Text style={styles.linkText}>Fornecedores</Text>
          </Link>
        </View>
      </View>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#121120',
    alignItems: 'center',
    justifyContent: 'center',
    padding: 20,
  },
  welcomeText: {
    fontSize: 28,
    fontWeight: 'bold',
    color: '#fff',
    marginBottom: 20,
  },
  linksContainer: {
    width: '100%',
  },
  linkRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 15,
  },
  linkButton: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: '#1c0736',
    padding: 15,
    borderRadius: 8,
    width: '48%',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.3,
    shadowRadius: 8,
    borderWidth: 1,
    borderColor: '#6c26bb',
  },
  linkText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: 'bold',
    marginLeft: 8, 
  },
  icon: {
    marginRight: 8,
  },
});

export default Home;
