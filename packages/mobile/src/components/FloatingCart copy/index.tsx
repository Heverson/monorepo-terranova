import React, {useMemo} from 'react';
import {useNavigation} from '@react-navigation/native';
import Icons from 'react-native-vector-icons/Feather';
import {
  Container,
  CartPricing,
  CartButton,
  CartButtonText,
  //CartTotalPrice,
} from './styles';

//import formatValue from '../../utils/formatValue';
import {useCart} from '../../hooks/cart';

const FloatingCart: React.FC = () => {
  const {products} = useCart();
  const navigation = useNavigation();
  // const cartTotal = useMemo(() => {
  //   // TODO RETURN THE SUM OF THE PRICE FROM ALL ITEMS IN THE CART
  //   const total = products.reduce((accum, curr) => {
  //     return accum + curr.preco * curr.quantity;
  //   }, 0);
  //   return formatValue(total);
  // }, [products]);

  const totalItensInCart = useMemo(() => {
    // TODO RETURN THE SUM OF THE QUANTITY OF THE PRODUCTS IN THE CART
    const total = products.reduce((accum, curr) => {
      return accum + curr.quantity;
    }, 0);
    return total;
  }, [products]);

  return (
    <Container>
      <CartButton onPress={() => navigation.navigate('Budgets')}>
        <Icons name="shopping-cart" size={24} color="#fff" />
        <CartButtonText>{`${totalItensInCart} itens`}</CartButtonText>
      </CartButton>

      <CartButton onPress={() => navigation.navigate('Budgets')}>
        {/* <CartTotalPrice>{cartTotal}</CartTotalPrice> */}
        <Icons name="file-text" size={24} color="#fff" />
        <CartButtonText>Minha Lista</CartButtonText>
      </CartButton>
    </Container>
  );
};

export default FloatingCart;
