import React, { useState, useRef } from 'react';
import {
  View,
  Text,
  StyleSheet,
  TouchableOpacity,
  Animated,
  Dimensions,
} from 'react-native';
import { Ionicons } from '@expo/vector-icons';

const HamburgerMenu: React.FC = () => {
  const [menuVisible, setMenuVisible] = useState(false);
  const slideAnim = useRef(new Animated.Value(Dimensions.get('window').height)).current;
  const opacityAnim = useRef(new Animated.Value(0)).current;
  const backgroundOpacityAnim = useRef(new Animated.Value(0)).current;  // Nova animação para o fundo

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
          toValue: 0,  // Desaparecer o fundo escuro
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
          toValue: 0.6,  // Ativar a camada escura
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

            <TouchableOpacity style={styles.menuOption}>
              <Ionicons name="home-outline" size={24} color="#fff" />
              <Text style={styles.menuText}>Home</Text>
            </TouchableOpacity>
            <TouchableOpacity style={styles.menuOption}>
              <Ionicons name="calendar-outline" size={24} color="#fff" />
              <Text style={styles.menuText}>Eventos</Text>
            </TouchableOpacity>
            <TouchableOpacity style={styles.menuOption}>
              <Ionicons name="settings-outline" size={24} color="#fff" />
              <Text style={styles.menuText}>Configurações</Text>
            </TouchableOpacity>
          </View>
        </Animated.View>
      )}
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    position: 'absolute',
    flex: 1,
    backgroundColor: '#121120',
    alignItems: 'center',
    justifyContent: 'center',
    zIndex: 10,
  },
  hamburgerButton: {
    position: 'absolute',
    top: -400,
    right: -170,
    zIndex: 10,
    backgroundColor: '#1c0736',
    padding: 10,
    borderRadius: 5,
    elevation: 5,
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
  },
  closeButton: {
    // position: 'absolute',
    // top: -290,
    // right: -60,
    // zIndex: 19,
    // backgroundColor: '#6c26bb',
    // padding: 10,
    // borderRadius: 5,
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
