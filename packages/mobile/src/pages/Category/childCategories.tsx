import React from 'react';
import {FlatList, TouchableHighlight, View} from 'react-native';
import { Feather } from '@expo/vector-icons';
import {useNavigation} from '@react-navigation/native';
import {NavLiChild, NavLiChildText} from './styles';


interface CategoryProps{
  codigo: string;
  titulo: string;
}

interface ChildCategoriesItem  {
  child: CategoryProps[];
}

const ChildCategories: React.FC<ChildCategoriesItem> = ({child}) => {
  const navigation = useNavigation();
  return (
    <>
      <FlatList
        data={child}
        keyExtractor={(item) => item.codigo}
        renderItem={({item}) => (
          <TouchableHighlight
            onPress={() => {
              navigation.navigate('Products', {
                categoryId: item.codigo,
                categoryName: item.titulo,
              });
            }}>
            <NavLiChild>
              <View style={{flexDirection: 'row'}}>
                <Feather size={12} name="corner-down-right" color="#2C1123" />
                <NavLiChildText>{item.titulo}</NavLiChildText>
              </View>
              <Feather size={20} name="chevron-right" color="#e7278e" />
            </NavLiChild>
          </TouchableHighlight>
        )}
      />
    </>
  );
};
export default ChildCategories;
