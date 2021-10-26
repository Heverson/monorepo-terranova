import React from "react";

import { View, Text, Image } from "react-native";

import { Container, GridProducts, CardProducts } from "./styles";

interface Product {
  titulo?: string;
  codigo: number;
  referencia?: string;
  codembalagem?: string;
  categoria_id?: string;
  categoria?: string;
  categoria_caminho?: string;
  marca_id?: string;
  marca?: string;
  quantity?: number;
  img: string;
}

interface ListProductsProps {
  column: number;
  products: Product[];
}

export function ListProducts({ column, products }) {
  const _renderItem = ({ item }: { item: Product }) => {
    return (
      <CardProducts
        style={{
          backgroundColor: "#FFF",
          height: 108,
          padding: 8,
          justifyContent: "space-between",
        }}
      >
        <Image
          key={item.codigo}
          source={{
            uri: `${item.img}`,
          }}
          style={{
            width: 100,
            height: 100,
            resizeMode: "contain",
          }}
        />
      </CardProducts>
    );
  };

  return (
    <Container>
      <GridProducts
        data={products}
        keyExtractor={(item) => item.codigo}
        numColumns={column}
        renderItem={_renderItem}
      />
    </Container>
  );
}
