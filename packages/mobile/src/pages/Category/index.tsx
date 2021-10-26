import React,{useState, useEffect} from 'react';
import { Feather } from '@expo/vector-icons';
import {useNavigation} from '@react-navigation/native';
import {useFetch} from '../../hooks/useFetch';
import {endpoints} from '../../services/api';
  
import { Text, View, FlatList, TouchableHighlight } from 'react-native';

import LottieView from 'lottie-react-native';
const icon_lottie = '../../assets/shampoo-loading.json';
import ChildCategories from './childCategories';

import {
  Container,
  HeaderCategoryList,
  HeaderCategoryTitle,
  HeaderCategoryTitleText,
  HeaderCategoryDescription,
  HeaderCategoryBackButton,
  NavLi,
  NavLiText,
  NavLineSeparator,
} from './styles';

interface CategoriesItem  {
  codigo: string;
  titulo: string;
  filhos: [];
}

const Categories: React.FC = () => {
 
  const navigation = useNavigation();


    const {data: categories, error} = useFetch(`${endpoints.API}get/categories`,  )

    console.log(categories)

  return (
    <>
      <Container>
        <HeaderCategoryList>
          <HeaderCategoryTitle>
            <HeaderCategoryBackButton>
              <Feather
                onPress={() => navigation.navigate('Home')}
                name="chevron-left"
                size={40}
                color="#E83F5B"
              />
            </HeaderCategoryBackButton>
            <HeaderCategoryTitleText>
            Elige una categoría
            </HeaderCategoryTitleText>
          </HeaderCategoryTitle>
          <HeaderCategoryDescription>
            {categories
              ? 'Haga clic en la categoría de producto que está buscando y agregar a su carrito, luego envíenos su solicitud de presupuesto.'
              : null}
          </HeaderCategoryDescription>
        </HeaderCategoryList>
        {error ? (
          <View
            style={{
              flex: 1,
              justifyContent: 'center',
              alignItems: 'center',
              padding: 20,
            }}>
            <Text>
              Ocorreu um erro na solicitação das categorias {'\n'} Verifique sua
              conexão com a internet
            </Text>
          </View>
        ) : null}
        {categories ? (
          <FlatList
            data={categories.data}
            keyExtractor={(item:CategoriesItem) => item.codigo}
            renderItem={({item}) => (
              <>
                <TouchableHighlight
                  onPress={() =>
                    navigation.navigate('Product', {
                      categoryId: item.codigo,
                      name: item.titulo,
                    })
                  }>
                  <NavLi>
                    <NavLiText>{item.titulo}</NavLiText>
                    <Feather size={20} name="chevron-right" color="#3b5998" />
                  </NavLi>
                </TouchableHighlight>
                {item.filhos ? <ChildCategories child={item.filhos} /> : null}
              </>
            )}
            ItemSeparatorComponent={() => <NavLineSeparator />}
          />
        ) : (
          <View
            style={{
              flex: 2,
              flexDirection: 'column',
              justifyContent: 'center',
              alignItems: 'center',
              padding: 20,
            }}>
            <LottieView
              source={require(icon_lottie)}
              autoPlay
              loop
              speed={0.7}
              style={{
                width: 180,
                paddingBottom:10
              }}
            />
            <Text style={{color:"#fff"}}>Carregando categorias ...</Text>
          </View>
        )}
      </Container>
    </>
  );
};

export default Categories;