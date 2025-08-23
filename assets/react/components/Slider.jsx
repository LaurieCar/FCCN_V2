import React, { useEffect, useRef, useState } from "react";
import '../../styles/slider.css';

const Slider = () => {

    const [currentSlide, setCurrentSlide] = useState(0);
    const [isAnimationPaused, setIsAnimationPaused] = useState(false);
    const sliderRef = useRef(null);
    const timeoutRef = useRef(null);
    const [images, setImages] = useState([]); 

    // Appel API Carousel Image
    useEffect(() => {
    fetch("/carousel") // ← ou "/carousel"
      .then((res) => {
        if (!res.ok) throw new Error("HTTP " + res.status);
        return res.json();
      })
      .then((data) => {
        const sorted = Array.isArray(data)
          ? [...data].sort((a, b) => (a.orderImage ?? 0) - (b.orderImage ?? 0))
          : [];
        setImages(sorted); // ← on alimente le state
      })
      .catch((err) => {
        console.error("Erreur API carousel:", err);
        setImages([]);
      });
  }, []);

    // Durée totale de l'animation 16s et par slide 4s
    const totalAnimationTime = 16000;
    const slideInterval = images.length ? (totalAnimationTime / images.length) : 0;

    useEffect(() => {
        // démarrer l'animation automatique
        if (!images.length || !slideInterval) return;
        startAutoSlide();

        // Nettoyer le timeout lors du démontage
        return () => {
            if(timeoutRef.current) {
                clearTimeout(timeoutRef.current);
            }
        };
    }, [images.length, slideInterval]);

    const startAutoSlide = () => {
        if (!images.length || !slideInterval) return;

        if(timeoutRef.current) {
            clearTimeout(timeoutRef.current);
        }

        const slideToNext = () => {
            setCurrentSlide(prev => (prev + 1) % images.length);
            timeoutRef.current = setTimeout(slideToNext, slideInterval);
        };

        timeoutRef.current = setTimeout(slideToNext, slideInterval);
    };

    const handleDotCLick = (index) => {
        setCurrentSlide(index);
        setIsAnimationPaused(true);

        // Arreter l'animation automatique
        if(timeoutRef.current) {
            clearTimeout(timeoutRef.current);
        }

        // reprendre l'animation après 2s
        setTimeout(() => {
            setIsAnimationPaused(false);
            // redémarrer l'animation depuis la slide actuelle
            startAutoSlide();
        }, 2000);
    };

    if(!images || images.length === 0) {
        return <div className="slider-1">Aucune image à afficher</div>
    }

    return (
        <div className="slider-1">
            <div
                ref={sliderRef}
                className={`slider ${isAnimationPaused ? 'paused' : ''}`}
                style={{
                    transform: isAnimationPaused ? `translateX(-${currentSlide * 100}%)` : undefined,
                    animation: isAnimationPaused ? 'none' : undefined
                }}
            >
                {images.map((image, index) => (
                    <div key={image.id} className="slide-div">
                        <img src={image.url} alt={image.name}/>
                    </div>
                ))}
            </div>

            {/* Navigation dots */}
            <div className="dots">
                {images.map((_, index) => (
                    <div
                        key={index}
                        className={`dot ${currentSlide === index && isAnimationPaused ? 'active' : ''}`}
                        onClick={() => handleDotCLick(index)}
                        style={{
                            animation: isAnimationPaused ? 'none' : undefined,
                            background: (currentSlide === index && isAnimationPaused) ? '#333333' : undefined
                        }}
                    />
                ))}
            </div>
        </div>
    );
};

export default Slider;