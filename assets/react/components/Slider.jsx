import React, { useEffect, useRef, useState } from "react";
import '../../styles/slider.css';

const Slider = ({images = []}) => {

    const [currentSlide, setCurrentSlide] = useState(0);
    const [isAnimationPaused, setIsAnimationPaused] = useState(false);
    const sliderRef = useRef(null);
    const timeoutRef = useRef(null);

    // Durée totale de l'animation 16s et par slide 4s
    const totalAnimationTime = 16000;
    const slideInterval = totalAnimationTime / images.length;

    useEffect(() => {
        // démarrer l'animation automatique
        startAutoSlide();

        // Nettoyer le timeout lors du démontage
        return () => {
            if(timeoutRef.current) {
                clearTimeout(timeoutRef.current);
            }
        };
    }, [images.length]);

    const startAutoSlide = () => {
        if(timeoutRef.current) {
            clearTimeout(timeoutRef.current);
        }

        const slideToNext = () => {
            setCurrentSlide(prev => (prev + 1) % images.length);
            timeoutRef.current = setTimeout(slideToNext, slideInterval);
        };

        timeoutRef.current = setTimeout(slideToNext, slideInterval);
    };

    const handledotCLick = (index) => {
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
                        onClick={() => handleDotClick(index)}
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