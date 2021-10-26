import React, {
  createContext,
  useState,
  useMemo,
  useContext,
  useEffect,
  useCallback,
} from 'react';
import AsyncStorage from '@react-native-async-storage/async-storage';

interface Product {
  titulo: string;
  codigo: string;
  referencia: string;
  codembalagem: string;
  categoria_id: string;
  categoria: string;
  categoria_caminho: string;
  marca_id: string;
  marca: string;
  quantity: number;
  preco: number;
}

interface ICartContext {
  products: Product;
  addToCart(item: Omit<Product, 'quantity'>): void;
  increment(id: string): void;
  decrement(id: string): void;
  removeToCart(id: string): void;
}

const CartContext = createContext<ICartContext | null>(null);

const CartProvider: React.FC = ({children}) => {
  const [products, setProducts] = useState<Product[]>([]);

  useEffect(() => {
    // carregar os prodytos do localstorage
    async function loadStorage() {
      const productList = await AsyncStorage.getItem('@TerraNova:products');
      if (productList) {
        setProducts([...JSON.parse(productList)]);
      }
    }
    loadStorage();
  }, []);

  const addToCart = useCallback(
    async (product) => {
      const idDuplicated = products.find(
        (item) => item.codigo === product.codigo,
      );
      if (idDuplicated) {
        setProducts(
          products.map((p) =>
            p.codigo === product.codigo
              ? {...product, quantity: p.quantity + 1}
              : p,
          ),
        );
      } else {
        setProducts([...products, {...product, quantity: 1}]);

        await AsyncStorage.setItem(
          '@TerraNova:products',
          JSON.stringify(products),
        );
      }
    },
    [products],
  );

  const increment = useCallback(
    async (id) => {
      const newProducts = products.map((product) =>
        product.codigo === id
          ? {...product, quantity: product.quantity + 1}
          : product,
      );

      setProducts(newProducts);

      await AsyncStorage.setItem(
        '@TerraNova:products',
        JSON.stringify(newProducts),
      );
    },
    [products],
  );

  const removeToCart = useCallback(
    async (id) => {
      const newProducts = products.filter((product) => product.codigo !== id);
      setProducts(newProducts);

      await AsyncStorage.setItem(
        '@TerraNova:products',
        JSON.stringify(newProducts),
      );
    },
    [products],
  );

  const decrement = useCallback(
    async (id) => {
      const newProducts = products.map((product) =>
        product.codigo === id
          ? {
              ...product,
              quantity: product.quantity > 0 ? product.quantity - 1 : 0,
            }
          : product,
      );

      setProducts(newProducts);

      await AsyncStorage.setItem(
        '@TerraNova:products',
        JSON.stringify(newProducts),
      );
    },
    [products],
  );

  const value = useMemo(
    () => ({
      addToCart,
      removeToCart,
      increment,
      decrement,
      products,
    }),
    [addToCart, removeToCart, increment, decrement, products],
  );
  return <CartContext.Provider value={value}>{children}</CartContext.Provider>;
};

function useCart(): ICartContext {
  const context = useContext(CartContext);
  if (!context) {
    throw new Error('useCart must be used withi CartProvider');
  }
  return context;
}

export {CartProvider, useCart};
