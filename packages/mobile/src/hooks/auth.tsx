/**
 * createContext
 * provider
 * useContext
 */

import React, {
  createContext,
  useContext,
  useState,
  useEffect,
  useCallback,
} from "react";
import AsyncStorage from "@react-native-community/async-storage";
import { api } from "../services/api";

/**
 * <o que vai ter na função conexto>
 * signIn recebe <email, password>
 */
interface User {
  id: number;
  nome: string;
  email: string;
  cpf: string;
  fone: string;
  codfilial: string;
  data_nascimento: string;
  cidade: string;
  estado: string;
  email_filial: string;
}

interface SignInCredentials {
  email: string;
  password: string;
}

interface AuthContextData {
  user: User;
  loading: boolean;
  signIn(creadentials: SignInCredentials): Promise<void>;
  signOut(): void;
}

interface AuthState {
  user: User;
}

const AuthContext = createContext<AuthContextData>({} as AuthContextData);

const AuthProvider: React.FC = ({ children }) => {
  const [data, setData] = useState<AuthState>({} as AuthState);
  const [loading, setLoading] = useState(true);
  // ao iniciar a aplicação verifica se usuário está logado
  useEffect(() => {
    // carrega os dados do usuário
    async function loadStorageData(): Promise<void> {
      const user = await AsyncStorage.getItem("@TerraNova:user");
      // se encontrou os dados da autenticação
      if (user) {
        setData({
          user: JSON.parse(user),
        });
      }
      setLoading(false);
    }

    console.log(data);

    loadStorageData();
  }, []);

  const signIn = useCallback(async ({ email, password }) => {
    // requisitar o login na api
    setLoading(true);
    const response = await api.post("post/sessions", {
      email,
      password,
    });
    console.log(response.data);
    const user = response.data;
    // se retornar ok, armamazenar no Storage
    // armazeno no AsyncStorage
    await AsyncStorage.setItem("@TerraNova:user", JSON.stringify(user));
    // setar os dados
    setData({
      user: user,
    });
    setLoading(false);
  }, []);

  const signOut = useCallback(async () => {
    await AsyncStorage.removeItem("@TerraNova:user");
    setData({} as AuthState);
  }, []);

  // retornar o auth context
  return (
    <AuthContext.Provider value={{ user: data.user, loading, signIn, signOut }}>
      {children}
    </AuthContext.Provider>
  );
};

// criar a função de acesso ao contexto
function useAuth(): AuthContextData {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error("useAuth must be used within and AuthProvider");
  }
  return context;
}

export { AuthProvider, useAuth };
