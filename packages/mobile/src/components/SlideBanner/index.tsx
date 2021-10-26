import React from "react";
import Slideshow from "react-native-image-slider-show";

import { Container } from "./styles";
interface BannersProps {
  imgUrl: string;
}
interface Props {
  banners: BannersProps[];
}
export function SlideBanner({ banners }: Props) {
  const bannersUrl = () => {
    return banners.map((item) => {
      url: item.imgUrl;
    });
  };
  return (
    <Container>
      <Slideshow
        style={{ borderRadius: 5 }}
        position={0}
        interval="null"
        dataSource={bannersUrl}
      />
    </Container>
  );
}
