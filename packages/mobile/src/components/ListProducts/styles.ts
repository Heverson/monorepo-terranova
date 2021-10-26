import styled from "styled-components/native";

export const Container = styled.View`
  margin: 16px 0;
`;

export const GridProducts = styled.FlatList.attrs({
  showsVerticalScrollIndicator: false,
})``;

export const CardProducts = styled.View`
  align-items: center;
  flex-direction: column;
  flex-grow: 1;
  margin: 4px;
  flex-basis: 0;
  padding: 0px;
  border-radius: 4px;
  justify-content: space-between;
`;

export const CardProductsHeader = styled.View`
  flex-direction: row;
  justify-content: space-between;
`;
export const CardProductsBody = styled.View`
  justify-content: space-between;
  align-items: center;
  width: 100%;
  padding: 15px 10px;
  border-radius: 5px;
`;
export const ImageProductContainer = styled.View`
  width: 100%;
  justify-content: flex-start;
  align-items: center;
  height: 130px;
`;
export const NotImageProduct = styled.View`
  width: 200px;
  min-height: 200px;
  background-color: #e2e2e2;
  margin: 3px;
`;
export const TitleProduct = styled.Text`
  padding: 2px;
  text-transform: capitalize;
  font-size: 16px;
`;
