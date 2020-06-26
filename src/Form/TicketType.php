<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', null, [])
            ->add('statut', ChoiceType::class, ['choices' => [
                'Non traité' => 'non_traite',
                'En cours' => 'en_cours',
                'Résolu' => 'resolu',
                'Non résolu' => 'non_resolu'
            ]])
            ->add('technicien')
            ->add('demandeur')
            ->add('lieu')
            ->add('date_echeance', null, ['empty_data' => '-'])
            ->add('priorite', ChoiceType::class, ['label' => 'Priorité', 'choices' => [
                'Normale' => 'normale',
                'Haute' => 'haute',
                'Très haute' => 'tres_haute'
            ]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
