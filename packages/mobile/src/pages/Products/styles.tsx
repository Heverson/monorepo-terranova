import styled from 'styled-components/native';

export const Container = styled.View`
  flex: 1;
  padding: 20px 10px;
  background-color: #fff;
  justify-content: center;
`;

export const HeaderProductsList = styled.View`
  flex-direction: column;
`;
export const HeaderProductsTitle = styled.View`
  flex-direction: row;
  align-items: center;
`;
export const HeaderProductsTitleText = styled.Text`
  font-size: 26px;
  font-weight: bold;
  color: #190395;
  text-transform: capitalize;
  flex-wrap: wrap;
  flex: 1;
  font-family: 'Rosario_400Regular';
`;
export const HeaderProductsDescription = styled.Text`
  font-size: 16px;
  color: #383838;
  line-height: 24px;
  padding: 10px;
`;
export const HeaderProductsBackButton = styled.View`
  padding-right: 10px;
`;

export const ActionContainer = styled.View`
  flex-direction: row;
  align-self: flex-end;
  align-items: center;
  justify-content: space-between;

  margin-left: auto;
`;

export const ActionButton = styled.TouchableOpacity`
  background: rgba(232, 63, 91, 0.1);
  border-radius: 5px;
  padding: 12px;
  margin-bottom: 5px;
`;

export const ListProducts = styled.FlatList``;

export const MessageNotProducts = styled.View`
  justify-content: center;
  align-items: center;
  width: 100%;
`;
export const ContainerLoadingData = styled.View`
  justify-content: center;
  align-items: center;
  width: 100%;
  flex: 1;
`;
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
export const PriceProduct = styled.Text`
  padding: 1px;
  font-weight: bold;
  font-size: 18px;
`;
export const BudgetContainer = styled.View`
  border-radius: 30px;
  background-color: #f21313;
  width: 60px;
  height: 60px;
  right: 10px;
  align-items: center;
  justify-content: center;
`;
export const BudgetNumber = styled.View`
  border-radius: 10px;
  background-color: #f21313;
  width: 20px;
  height: 20px;
  justify-content: center;
  align-items: center;
  margin-top: -30px;
  margin-right: -30px;
`;
export const BudgetNumberText = styled.Text`
  font-weight: bold;
  color: #fff;
`;
export const Footer = styled.View`
  justify-content: flex-end;
  align-items: flex-end;
`;
