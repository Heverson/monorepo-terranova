import React from 'react';

import { View, Text, ListRenderItem, Image} from 'react-native';

import { Carousel } from './styles';
interface CarouselProps{
  url: string
}
interface ListCarousel{
  item: CarouselProps[]
}

const CarouselBrands: React.FC = () => {
  const DATA = [
    {
      url: 'https://shoppingterranova.com.py/files/for_792.jpg'
    },
    {
      url: 'https://shoppingterranova.com.py/files/for_839.png'
    },
    {
      url: 'https://shoppingterranova.com.py/files/for_714.png'
    },
    {
      url: 'https://shoppingterranova.com.py/files/for_679.png'
    },
    {
      url: 'https://shoppingterranova.com.py/files/for_716.png'
    },
    {
      url: 'https://shoppingterranova.com.py/files/for_430.jpg'
    },
    {
      url: 'https://shoppingterranova.com.py/files/for_540.jpg'
    },
    {
      url: 'https://shoppingterranova.com.py/files/for_587.jpg'
    },
    {
      url: 'https://shoppingterranova.com.py/files/for_701.jpg'
    },
    {
      url: 'https://shoppingterranova.com.py/files/for_729.jpg'
    },
    {
      url: 'https://shoppingterranova.com.py/files/for_731.jpg'
    },
    {
      url: 'https://shoppingterranova.com.py/files/for_761.jpg'
    },
    {
      url: 'https://shoppingterranova.com.py/files/for_784.jpg'
    },
    {
      url: 'https://shoppingterranova.com.py/files/for_843.jpg'
    },
    {
      url: 'https://shoppingterranova.com.py/files/for_869.jpg'
    },
    {
      url: 'https://shoppingterranova.com.py/files/for_897.jpg'
    },
    {
      url: 'https://shoppingterranova.com.py/files/for_904.jpg'
    }
  ];
  const _renderItem= ({item}:{item: CarouselProps}) => {
    return (
      <View>
        <Image 
          key={item.url} 
          source={{
            uri:`${item.url}`
          }}
          style={{
            width: 100,
            height: 100,
            resizeMode: 'contain'
          }}
        />
      </View>
    );
  }

  return (
    <Carousel
      horizontal
      data={DATA}
      renderItem={_renderItem}
    />
  );
};

export default CarouselBrands;
