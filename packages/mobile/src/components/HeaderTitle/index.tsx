import React from 'react';

import { Text } from 'react-native';

import { Container,  TitleScreen } from './styles';

const HeaderTitle: React.FC = ({children}) => {
  return (
    <Container>
      <TitleScreen>{children}</TitleScreen>
    </Container>
  );
};

export default HeaderTitle;
