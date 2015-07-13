<?php

namespace FDevs\MenuBundle\Form\Type;

use Cocur\Slugify\Slugify;
use FDevs\Locale\Util\ChoiceText;
use FDevs\MenuBundle\Model\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuNodeType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', 'trans_text')
            ->add('parent', 'fdevs_menu_parent')
            ->add('display', 'checkbox', ['required' => false])
            ->add('name', 'text', ['required' => false])
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                function (FormEvent $event) {
                    $data = $event->getData();
                    if (empty($data['name']) && count($data['label'])) {
                        $data['name'] = Slugify::create()->slugify(ChoiceText::getFirstText($data['label']));
                        $event->setData($data);
                    }
                }
            );
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'FDevs\MenuBundle\Model\Menu']);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'fdevs_menu_node';
    }
}
