import React, { useState, useRef } from 'react';
import { View, Text, StyleSheet, TouchableOpacity, Animated, Dimensions } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { Link } from 'expo-router';

const HamburgerMenu: React.FC = () => {
  const [menuVisible, setMenuVisible] = useState(false);
  const slideAnim = useRef(new Animated.Value(Dimensions.get('window').height)).current;
  const opacityAnim = useRef(new Animated.Value(0)).current;
  const backgroundOpacityAnim = useRef(new Animated.Value(0)).current;

  const toggleMenu = () => {
    if (menuVisible) {
      Animated.parallel([
        Animated.timing(slideAnim, {
          toValue: Dimensions.get('window').height,
          duration: 300,
          useNativeDriver: false,
        }),
        Animated.timing(opacityAnim, {
          toValue: 0,
          duration: 300,
          useNativeDriver: false,
        }),
        Animated.timing(backgroundOpacityAnim, {
          toValue: 0,
          duration: 300,
          useNativeDriver: false,
        }),
      ]).start(() => setMenuVisible(false));
    } else {
      setMenuVisible(true);
      Animated.parallel([
        Animated.timing(slideAnim, {
          toValue: 0,
          duration: 300,
          useNativeDriver: false,
        }),
        Animated.timing(opacityAnim, {
          toValue: 1,
          duration: 300,
          useNativeDriver: false,
        }),
        Animated.timing(backgroundOpacityAnim, {
          toValue: 0.6,
          duration: 300,
          useNativeDriver: false,
        }),
      ]).start();
    }
  };

  return (
    <View style={styles.container}>
      <TouchableOpacity onPress={toggleMenu} style={styles.hamburgerButton}>
        <Ionicons name="menu" size={28} color="#fff" />
      </TouchableOpacity>

      {/* Camada escura atrás do menu */}
      {menuVisible && (
        <Animated.View
          style={[styles.overlay, { opacity: backgroundOpacityAnim }]} // Aplica animação de opacidade
        />
      )}

      {menuVisible && (
        <Animated.View
          style={[styles.menuContainer, { top: slideAnim, opacity: opacityAnim }]}
        >
          <View style={styles.menuContent}>
            <TouchableOpacity onPress={toggleMenu} style={styles.closeButton}>
              <Ionicons name="close" size={28} color="#fff" />
            </TouchableOpacity>

            <Link href="/home" style={styles.menuOption} onPress={toggleMenu}>
              <Ionicons name="home-outline" size={24} color="#fff" />
              <Text style={styles.menuText}>Home</Text>
            </Link>

            <Link href="/productList" style={styles.menuOption} onPress={toggleMenu}>
              <Ionicons name="cube-outline" size={24} color="#fff" />
              <Text style={styles.menuText}>Produtos</Text>
            </Link>

            <Link href="/eventList" style={styles.menuOption} onPress={toggleMenu}>
              <Ionicons name="calendar-outline" size={24} color="#fff" />
              <Text style={styles.menuText}>Eventos</Text>
            </Link>

            <Link href="/https://docs.google.com/spreadsheets/u/0/d/1m0L1dx60k05oz-6jqm8h9NDiqRTBc9gOe5X14t2aYw0/htmlview" style={styles.menuOption} onPress={toggleMenu}>
              <Ionicons name="people-outline" size={24} color="#fff" />
              <Text style={styles.menuText}>Fornecedores</Text>
            </Link>

            <Link href="/" style={styles.menuOption} onPress={toggleMenu}>
              <Ionicons name="log-out-outline" size={24} color="#fff" />
              <Text style={styles.menuText}>Logout</Text>
            </Link>
          </View>
        </Animated.View>
      )}
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    position: 'absolute',
    zIndex: 1000,
  },
  hamburgerButton: {
    bottom: 390,
    left: 150,
    backgroundColor: '#1c0736',
    padding: 10,
    borderRadius: 20,
    elevation: 5,
    zIndex: 1000,
  },
  overlay: {
    position: 'absolute',
    width: '100%',
    height: '100%',
    backgroundColor: 'rgba(0, 0, 0, 0.6)', 
    zIndex: 4, 
  },
  menuContainer: {
    position: 'absolute',
    width: '100%',
    height: '100%',
    backgroundColor: '#1c0736',
    justifyContent: 'center',
    alignItems: 'center',
    zIndex: 5,
  },
  menuContent: {
    backgroundColor: '#1c0736',
    padding: 100,
    alignItems: 'center',
    borderRadius: 20,
  },
  closeButton: {
   
  },
  menuOption: {
    flexDirection: 'row',
    alignItems: 'center',
    marginVertical: 15,
    padding: 10,
  },
  menuText: {
    color: '#fff',
    fontSize: 20,
    fontWeight: 'bold',
    marginLeft: 10,
  },
});

export default HamburgerMenu;
