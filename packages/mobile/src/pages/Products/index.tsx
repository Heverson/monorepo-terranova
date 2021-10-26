import React from 'react';
import {SafeAreaView, View, Text, Image} from 'react-native';
import {useNavigation} from '@react-navigation/native';
import {Feather} from '@expo/vector-icons';
import LottieView from 'lottie-react-native';
import {endpoints} from '../../services/api';
  
import {useCart} from '../../hooks/cart';

import {useFetch} from '../../hooks/useFetch';

import FloatingCart from '../../components/FloatingCart';

const icon_lottie = '../../assets/shampoo-loading.json';

import {
  Container,
  HeaderProductsList,
  HeaderProductsTitle,
  HeaderProductsTitleText,
  HeaderProductsDescription,
  HeaderProductsBackButton,
  ListProducts,
  CardProducts,
  CardProductsBody,
  ImageProductContainer,
  NotImageProduct,
  TitleProduct,
  ActionContainer,
  ActionButton,
  Footer,
  ContainerLoadingData,
} from './styles';

interface IRouteParams {
  params: {
    categoryId: number;
    categoryName: string;
  };
}

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

const Products: React.FC = ({route}) => {
  //route;
  const {addToCart} = useCart();

  const {categoryId} = route.params;
  const {categoryName} = route.params;

  const {data: products, error} = useFetch(
    `${endpoints.API}get/categories/${categoryId}`,
  );
  console.log(products, error)
  const navigation = useNavigation();

  function handleAddToCart(item: Product): void {
    // TODO
    addToCart(item);
  }
  return (
    <>
      <SafeAreaView />
      <Container>
        <HeaderProductsList>
          <HeaderProductsTitle>
            <HeaderProductsBackButton>
              <Feather                
                onPress={() => navigation.navigate('Categories')}
                name="chevron-left"
                size={40}
                color="#E83F5B"
              />
            </HeaderProductsBackButton>
            <HeaderProductsTitleText>{categoryName}</HeaderProductsTitleText>
          </HeaderProductsTitle>
          <HeaderProductsDescription>
            Adicione na sua lista de orçamento clicando no [+]
          </HeaderProductsDescription>
        </HeaderProductsList>
        {error ? (
          <View>
            <Text>
              Ocorreu um erro na solicitação dos produtos {'\n'} Verifique sua
              conexão com a internet
            </Text>
          </View>
        ) : null}

        {products ? (
          <ListProducts
            data={products.products}
            keyExtractor={(item) => item.codigo}
            numColumns={2}
            showsVerticalScrollIndicator={false}
            renderItem={({item}) => {
              return (
                <CardProducts>
                  <CardProductsBody>
                    <ImageProductContainer>
                      {item.img.length > 0 ? (
                        <Image
                          style={{width: 100, height: 100}}
                          source={{
                            uri: item.img[0].urlp,
                            headers: {Authorization: 'BordingnonApp'},
                          }}
                          resizeMode="contain"
                        />
                      ) : (
                        <NotImageProduct />
                      )}
                    </ImageProductContainer>

                    <TitleProduct>{item.name}</TitleProduct>
                    {/* {item.preco > 0 ? (
                      <PriceProduct>{formatValue(item.preco)}</PriceProduct>
                    ) : null} */}
                    <ActionContainer>
                      <ActionButton onPress={() => handleAddToCart(item)}>
                        <Feather name="plus" color="#E83F5B" size={16} />
                      </ActionButton>
                    </ActionContainer>
                  </CardProductsBody>
                </CardProducts>
              );
            }}
          />
        ) : (
          <ContainerLoadingData>
            <LottieView
              source={require(icon_lottie)}
              autoPlay
              loop
              speed={0.7}
              style={{
                width: 180,
              }}
            />
            <Text>Carregando produtos ...</Text>
          </ContainerLoadingData>
        )}
        <Footer>
          {/* <BudgetContainer>
            {counterItemBudget > 0 ? (
              <BudgetNumber>
                <BudgetNumberText>{counterItemBudget}</BudgetNumberText>
              </BudgetNumber>
            ) : null}
            <Feather              
              name="playlist-add"
              onPress={() =>
                navigation.dispatch(
                  StackActions.reset({
                    index: 0,
                    actions: [
                      NavigationActions.navigate({
                        routeName: 'Budget',
                      }),
                    ],
                  }),
                )
              }
              size={34}
              color="#fff"
            />
          </BudgetContainer> */}
        </Footer>
      </Container>
      <FloatingCart />
    </>
  );
};

export default Products;
